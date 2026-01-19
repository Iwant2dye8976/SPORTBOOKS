<?php

namespace App\Services;

use App\Models\Book;

class ChatbotService
{
    public function handle(string $message, ?int $userId = null): array
    {
        $message = mb_strtolower($message);

        if ($this->isRecommendIntent($message)) {
            return $this->handleRecommend($userId);
        }

        if ($this->isSearchIntent($message)) {
            return $this->handleSearch($message);
        }

        return [
            'type' => 'text',
            'content' => 'Xin lỗi, tôi chưa hiểu yêu cầu. Bạn có thể hỏi về gợi ý sách hoặc tìm sách.'
        ];
    }

    protected function isRecommendIntent(string $msg): bool
    {
        return str_contains($msg, 'gợi ý');
    }

    protected function isSearchIntent(string $msg): bool
    {
        return str_contains($msg, 'tìm');
    }

    protected function handleRecommend(?int $userId): array
    {
        if (! $userId) {
            return [
                'type' => 'text',
                'content' => 'Bạn hãy đăng nhập để nhận gợi ý sách phù hợp hơn.'
            ];
        }

        $reco = app(RecommendationService::class);
        $books = $reco->recommendForUser($userId, 5);

        return [
            'type' => 'books',
            'content' => $books->map(fn($b) => [
                'id' => $b->id,
                'title' => $b->title,
            ])
        ];
    }

    protected function handleSearch(string $msg): array
    {
        $keyword = trim(str_replace('tìm', '', $msg));

        $books = Book::where('title', 'like', "%{$keyword}%")
            ->limit(5)
            ->get();

        return [
            'type' => 'books',
            'content' => $books->map(fn($b) => [
                'id' => $b->id,
                'title' => $b->title,
                'link' => route('detail', $b->id),
            ])
        ];
    }
}
