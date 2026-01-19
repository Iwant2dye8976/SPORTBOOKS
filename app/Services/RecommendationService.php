<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Interaction;
use App\Models\BookReviews;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * RecommendationService
 *
 * Responsibilities:
 *  - produce cached recommendations for users
 *  - realtime recommendations for sessions
 *  - book-to-book similarity recommendations
 *  - cold-start fallbacks
 *
 * Design decisions:
 *  - uses `interactions` table (user_id, book_id, action, weight)
 *  - uses `book_reviews` for rating info (model BookReview)
 *  - caches per-user results in Redis (Cache facade)
 */
class RecommendationService
{
    protected int $cacheTtlMinutes = 30; // cache lifetime

    // Hybrid weights (interaction | rating | content)
    protected array $hybridWeights;

    public function __construct()
    {
        $this->hybridWeights = config('reco.hybrid_weights', [
            'interaction' => 0.5,
            'rating' => 0.3,
            'content' => 0.2,
        ]);

        // allow override of ttl from config if present
        $this->cacheTtlMinutes = config('reco.cache_ttl_minutes', $this->cacheTtlMinutes);
    }

    /**
     * Public: recommend books for a logged-in user (cached)
     *
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Support\Collection of Book models
     */
    public function recommendForUser(int $userId, int $limit = 10)
    {
        $cacheKey = "reco:user:{$userId}";

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheTtlMinutes), function () use ($userId, $limit) {
            return $this->computeRecommendationsForUser($userId, $limit);
        });
    }

    /**
     * Invalidate cached recommendations for a user (call after purchase/review)
     */
    public function invalidateUserCache(int $userId): void
    {
        Cache::forget("reco:user:{$userId}");
    }

    /**
     * Compute recommendations for a user (no caching inside)
     * Steps:
     *  1) get user's item scores from interactions
     *  2) find similar users via co-occurrence
     *  3) aggregate candidate books from similar users
     *  4) compute hybrid score and return top N Book models
     */
    protected function computeRecommendationsForUser(int $userId, int $limit = 10)
    {
        // 1) user interactions (book_id => score)
        $userInteractions = $this->getUserInteractionAggregates($userId);

        // if user has no interactions -> cold start
        if ($userInteractions->isEmpty()) {
            return $this->coldStartForUser($limit);
        }

        // 2) find similar users
        $similarUserIds = $this->getSimilarUserIds($userId, 20);

        if (empty($similarUserIds)) {
            // fallback to content/popular
            return $this->coldStartForUser($limit);
        }

        // 3) aggregate candidate books from similar users
        $candidates = $this->aggregateCandidatesFromUsers($similarUserIds, $userId);

        if (empty($candidates)) {
            return $this->coldStartForUser($limit);
        }

        // 4) compute hybrid scores for candidates
        $scored = $this->scoreCandidatesHybrid($candidates, $userInteractions);

        // sort and take top
        arsort($scored);

        $topIds = array_slice(array_keys($scored), 0, $limit);

        $books = Book::whereIn('id', $topIds)->get()->keyBy('id');

        // preserve order
        $ordered = collect($topIds)->map(function ($id) use ($books) {
            return $books->get($id);
        })->filter();

        return $ordered;
    }

    /**
     * Real-time recommendations for session (not logged in)
     * uses session viewed_books or viewed book list passed in
     */
    public function recommendForSession(array $viewedBookIds = [], int $limit = 10)
    {
        if (empty($viewedBookIds)) {
            return $this->popularBooks($limit);
        }

        // simple content-based: recommend recent books from same categories / authors
        $categories = Book::whereIn('id', $viewedBookIds)->pluck('category')->filter()->unique()->values();

        $query = Book::query()->whereNotIn('id', $viewedBookIds);

        if ($categories->isNotEmpty()) {
            $query->whereIn('category', $categories->toArray());
        }

        return $query->orderBy('created_at', 'desc')->limit($limit)->get();
    }

    /**
     * Recommend books similar to a given book
     */
    public function recommendForBook(int $bookId, int $limit = 10)
    {
        $book = Book::find($bookId);

        if (! $book) {
            return collect();
        }

        // try embedding similarity first (if available)
        if (DB::getSchemaBuilder()->hasTable('book_embeddings')) {
            $embedRow = DB::table('book_embeddings')->where('book_id', $bookId)->first();
            if ($embedRow && $embedRow->embedding) {
                // naive approach: load embeddings into memory and compute cosine
                $all = DB::table('book_embeddings')->where('book_id', '!=', $bookId)->get();
                $scores = [];
                $base = json_decode($embedRow->embedding, true);
                foreach ($all as $r) {
                    $vec = json_decode($r->embedding, true);
                    if (! is_array($vec) || ! is_array($base)) continue;
                    $scores[$r->book_id] = $this->cosineSimilarity($base, $vec);
                }
                arsort($scores);
                $top = array_slice(array_keys($scores), 0, $limit);
                return Book::whereIn('id', $top)->get();
            }
        }

        // fallback: same category, same author, popular
        $query = Book::where('id', '!=', $bookId)
            ->where(function ($q) use ($book) {
                $q->where('category', $book->category)
                  ->orWhere('author', $book->author);
            })
            ->orderByDesc('created_at')
            ->limit($limit);

        $results = $query->get();

        if ($results->count() < $limit) {
            $needed = $limit - $results->count();
            $more = $this->popularBooks($needed);
            $results = $results->concat($more)->unique('id')->take($limit);
        }

        return $results;
    }

    /* ----------------------------- helpers ----------------------------- */

    /**
     * Get aggregated user interactions: book_id => sum(weight)
     */
    protected function getUserInteractionAggregates(int $userId)
    {
        $rows = Interaction::select('book_id', DB::raw('SUM(weight) as score'))
            ->where('user_id', $userId)
            ->groupBy('book_id')
            ->get();

        return $rows->pluck('score', 'book_id');
    }

    /**
     * Find similar user IDs by co-occurrence (limited)
     */
    protected function getSimilarUserIds(int $userId, int $limit = 20): array
    {
        // join interactions on same book
        $sub = DB::table('interactions as i1')
            ->join('interactions as i2', function ($join) use ($userId) {
                $join->on('i1.book_id', '=', 'i2.book_id')
                     ->where('i1.user_id', $userId)
                     ->whereColumn('i2.user_id', '!=', 'i1.user_id');
            })
            ->select('i2.user_id', DB::raw('SUM(i1.weight * i2.weight) as similarity'))
            ->groupBy('i2.user_id')
            ->orderByDesc('similarity')
            ->limit($limit)
            ->pluck('similarity', 'user_id');

        return $sub->keys()->map(fn($k) => (int)$k)->toArray();
    }

    /**
     * Aggregate candidate books from similar users, excluding books the target user already interacted with
     * Returns array book_id => aggregated_score
     */
    protected function aggregateCandidatesFromUsers(array $similarUserIds, int $targetUserId): array
    {
        if (empty($similarUserIds)) return [];

        // get books the target already interacted with
        $existing = Interaction::where('user_id', $targetUserId)->pluck('book_id')->unique()->toArray();

        // aggregate weights for candidate books
        $rows = Interaction::select('book_id', DB::raw('SUM(weight) as score'))
            ->whereIn('user_id', $similarUserIds)
            ->whereNotIn('book_id', $existing)
            ->groupBy('book_id')
            ->get();

        return $rows->pluck('score', 'book_id')->toArray();
    }

    /**
     * Compute hybrid score for candidates
     * candidates: [book_id => interaction_score]
     * userInteractions: Collection(book_id => score) used for normalization if needed
     */
    protected function scoreCandidatesHybrid(array $candidates, $userInteractions): array
    {
        // normalize interaction scores
        $maxInteraction = max(array_values($candidates)) ?: 1;

        // fetch ratings and basic content features for candidates
        $bookIds = array_keys($candidates);
        $books = Book::whereIn('id', $bookIds)->get()->keyBy('id');

        // get avg ratings
        $ratings = BookReviews::select('book_id', DB::raw('AVG(rating) as avg_rating'))
            ->whereIn('book_id', $bookIds)
            ->where('verified_purchase', true)
            ->groupBy('book_id')
            ->pluck('avg_rating', 'book_id')
            ->map(fn($v) => (float)$v)
            ->toArray();

        $scored = [];

        foreach ($candidates as $bookId => $interactionScore) {
            $interactionNorm = $interactionScore / $maxInteraction; // 0..1

            $ratingScore = isset($ratings[$bookId]) ? ($ratings[$bookId] / 5.0) : 0.0; // 0..1

            // simple content score: same category with any of user's top categories or same author
            $contentScore = $this->computeContentScore($bookId, $books->get($bookId), $userInteractions);

            $final = (
                $this->hybridWeights['interaction'] * $interactionNorm
                + $this->hybridWeights['rating'] * $ratingScore
                + $this->hybridWeights['content'] * $contentScore
            );

            $scored[$bookId] = $final;
        }

        return $scored;
    }

    /**
     * Compute a simple content score between a candidate book and the user's interaction history.
     * This is a heuristic (author/category/price) and can be replaced by embedding similarity.
     */
    protected function computeContentScore(int $bookId, ?Book $book, $userInteractions): float
    {
        if (! $book) return 0.0;

        // derive user's top categories from their interacted books
        $topBookIds = $userInteractions->sortDesc()->keys()->slice(0, 10)->toArray();

        if (empty($topBookIds)) return 0.0;

        $topCategories = Book::whereIn('id', $topBookIds)->pluck('category')->filter()->toArray();

        $score = 0.0;

        // same category
        if (in_array($book->category, $topCategories)) {
            $score += 0.6; // heavier
        }

        // author match
        $topAuthors = Book::whereIn('id', $topBookIds)->pluck('author')->filter()->unique()->toArray();
        if (! empty($book->author) && in_array($book->author, $topAuthors)) {
            $score += 0.3;
        }

        // normalize to [0,1]
        return min(1.0, $score);
    }

    /**
     * Cold start for users with no history: mix popular and high-rated books
     */
    protected function coldStartForUser(int $limit = 10)
    {
        $popular = $this->popularBooks((int)($limit * 1.5));

        // take top-rated among popular
        $bookIds = $popular->pluck('id')->toArray();

        $ratings = BookReviews::select('book_id', DB::raw('AVG(rating) as avg_rating'))
            ->whereIn('book_id', $bookIds)
            ->where('verified_purchase', true)
            ->groupBy('book_id')
            ->orderByDesc('avg_rating')
            ->pluck('avg_rating', 'book_id')
            ->toArray();

        // sort popular by rating if available
        $sorted = $popular->sortByDesc(function ($b) use ($ratings) {
            return $ratings[$b->id] ?? 0;
        })->take($limit);

        return $sorted->values();
    }

    /**
     * Get globally popular books (by purchases)
     */
    protected function popularBooks(int $limit = 10)
    {
        $rows = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->where('o.status', 4) // completed
            ->select('od.book_id', DB::raw('SUM(od.book_quantity) as purchases'))
            ->groupBy('od.book_id')
            ->orderByDesc('purchases')
            ->limit($limit)
            ->pluck('book_id')
            ->toArray();

        return Book::whereIn('id', $rows)->get();
    }

    /**
     * cosine similarity helper (expects arrays of numbers)
     */
    protected function cosineSimilarity(array $a, array $b): float
    {
        $dot = 0.0;
        $na = count($a);
        $nb = count($b);
        $n = min($na, $nb);
        $normA = 0.0;
        $normB = 0.0;

        for ($i = 0; $i < $n; $i++) {
            $dot += ($a[$i] ?? 0) * ($b[$i] ?? 0);
            $normA += ($a[$i] ?? 0) * ($a[$i] ?? 0);
            $normB += ($b[$i] ?? 0) * ($b[$i] ?? 0);
        }

        if ($normA == 0 || $normB == 0) return 0.0;

        return $dot / (sqrt($normA) * sqrt($normB));
    }
}
