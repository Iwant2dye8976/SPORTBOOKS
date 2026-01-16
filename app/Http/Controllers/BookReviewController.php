<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\InteractionHelper;
use App\Models\BookReviews;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class BookReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);


        if (! $this->userHasPurchased(Auth::user()->id, $data['book_id'])) {
            return back()->with('warning', 'Bạn chỉ có thể đánh giá các sản phẩm đã mua và nhận hàng.');
        }
        $review = BookReviews::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'book_id' => $data['book_id'],
            ],
            [
                'rating' => $data['rating'],
                'comment' => $data['comment'],
                'verified_purchase' => true,
            ]
        );

        InteractionHelper::log(
            'review',
            $data['book_id'],
            auth()->id(),
            [
                'rating' => $data['rating'],
            ]
        );

        return back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }

    private function userHasPurchased(int $userId, int $bookId): bool
    {
        return OrderDetail::where('book_id', $bookId)
            ->whereHas('order', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                    ->where('status', 4);
            })
            ->exists();
    }

    static function drawRatingStars($book)
    {
        $avgRating = $book->avgRating();
        $starsHtml = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= floor($avgRating)) {
                $starsHtml .= '<i class="fa-solid fa-star"></i>';
            } elseif ($i - $avgRating < 1) {
                $starsHtml .= '<i class="fa-solid fa-star-half-stroke"></i>';
            } else {
                $starsHtml .= '<i class="fa-regular fa-star"></i>';
            }
        }
        return $starsHtml;
    }
}
