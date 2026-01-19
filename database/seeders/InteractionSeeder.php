<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Book;
use App\Models\Interaction;
use App\Models\BookReviews;

class InteractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả user có type = 'user' (bỏ admin/deliverer)
        $users = User::where('type', 'user')->get();

        // Nếu không có user nào, tạo vài user test (nếu muốn)
        if ($users->isEmpty()) {
            $this->command->info('No users found with type=user. Creating demo users...');
            User::factory()->count(50)->create();
            $users = User::where('type', 'user')->get();
        }

        // Lấy tất cả sách, nhóm theo category (category là string enum)
        $booksByCategory = Book::all()->groupBy('category');

        // Nếu không có sách -> abort
        if ($booksByCategory->isEmpty()) {
            $this->command->warn('No books found. Please seed books first.');
            return;
        }

        // Quy ước trọng số (có thể lấy từ config/reco.php nếu bạn đã tạo)
        $weights = [
            'view' => 1,
            'add_to_cart' => 3,
            'purchase' => 5,
            'review' => 4,
        ];

        foreach ($users as $user) {
            // Mỗi user có 1-2 categories ưa thích (defensive: limit bằng số category hiện có)
            $categoryKeys = $booksByCategory->keys();
            $favCount = min(rand(1, 2), $categoryKeys->count());
            $favoriteCategories = $categoryKeys->shuffle()
                                                ->take($favCount)
                                                ->values();
            // $favoriteCategories có thể là Collection hoặc string (nếu count=1), so cast to array
            foreach ( $favoriteCategories as $category) {
                if (! isset($booksByCategory[$category])) {
                    continue;
                }

                $bookCollection = $booksByCategory[$category];

                // Chọn ngẫu nhiên 3..min(6, count(category)) sách, shuffle để phòng trường hợp count nhỏ
                $take = rand(3, min(6, $bookCollection->count()));
                $books = $bookCollection->shuffle()->take($take);

                foreach ($books as $book) {
                    // 1) view (luôn có)
                    $this->logInteraction($user->id, $book->id, 'view', $weights['view']);

                    // 2) add_to_cart (tỉ lệ 40%)
                    if (rand(1, 100) <= 40) {
                        $this->logInteraction($user->id, $book->id, 'add_to_cart', $weights['add_to_cart']);
                    }

                    // 3) purchase (tỉ lệ 25%)
                    if (rand(1, 100) <= 25) {
                        $this->logInteraction($user->id, $book->id, 'purchase', $weights['purchase']);

                        // 4) review (chỉ sau khi mua, tỉ lệ 70%)
                        if (rand(1, 100) <= 70) {
                            $rating = rand(4, 5); // sách mua thường đánh giá cao
                            BookReviews::updateOrCreate(
                                [
                                    'user_id' => $user->id,
                                    'book_id' => $book->id,
                                ],
                                [
                                    'rating' => $rating,
                                    'comment' => 'Sách rất hay, nội dung hữu ích.',
                                    'verified_purchase' => true,
                                ]
                            );

                            // ghi event review
                            $this->logInteraction($user->id, $book->id, 'review', $weights['review']);
                        }
                    }
                }
            }
        }

        $this->command->info('Interaction seeding finished.');
    }

    /**
     * Helper để tạo interaction (tự tạo event_id duy nhất)
     */
    protected function logInteraction(int $userId = null, int $bookId = null, string $action = 'view', int $weight = 1): void
    {
        // defensive: require bookId
        if (empty($bookId)) return;

        Interaction::create([
            'event_id' => (string) Str::uuid(),
            'user_id' => $userId,
            'book_id' => $bookId,
            'action' => $action,
            'weight' => $weight,
            'source' => 'seed',
        ]);
    }
}
