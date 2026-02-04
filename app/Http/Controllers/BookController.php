<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\InteractionHelper;
use App\Models\BookReviews;
use App\Http\Controllers\BookReviewController as BookReviewControllers;
use App\Services\RecommendationService;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getall(RecommendationService $reco)
    {
        $books = Book::paginate(10);
        $totalBooks = Book::count();
        $categories = Book::select('category')->distinct()->get();
        $recommendedBooks = [];
        $cart_count = 0;
        $order_count = 0;

        if (Auth::check()) {
            $cart_count = Cart::where('user_id', Auth::user()->id)->count();
            $order_count = Order::where('user_id', Auth::user()->id)->count();
            $recommendedBooks = $reco->recommendForUser(Auth::user()->id, 10);
            // if (Auth::user()->type === 'admin') {
            //     return view('admin.home', compact('books', 'totalBooks', 'categories', 'cart_count', 'order_count'));
            // }
        } else {
            $recommendedBooks = $reco->recommendForSession(
                session('viewed_books', []),
                10
            );
        }

        return view('user.home', compact('books', 'totalBooks', 'categories', 'cart_count', 'order_count', 'recommendedBooks'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function getDetail($id, RecommendationService $reco)
    {

        $book = Book::findOrFail($id);
        $reviews = BookReviews::where('book_id', $book->id)
            ->where('verified_purchase', true)
            ->get();
        InteractionHelper::log(
            'view',
            $book->id,
            auth()->id(),
            [
                'url' => request()->path(),
            ]
        );
        // $relatedBooks = Book::where('category', $book->category)
        //     ->where('id', '!=', $id)
        //     ->inRandomOrder()
        //     ->limit(5)
        //     ->get();

        $relatedBooks = $reco->recommendForBook($book->id, 10);

        $cart_count = 0;
        $order_count = 0;

        $reviews_count = $reviews->count();
        $ratingStats = [];

        $htmlRatingStars = BookReviewControllers::drawRatingStars($book);
        for ($star = 1; $star <= 5; $star++) {
            $count = $reviews->where('rating', $star)->count();

            $ratingStats[$star] = [
                'count' => $count,
                'percent' => $reviews_count > 0
                    ? round(($count / $reviews_count) * 100)
                    : 0
            ];
        }

        if (Auth::check()) {
            $cart_count = Cart::where('user_id', Auth::id())->count();
            $order_count = Order::where('user_id', Auth::user()->id)->count();
            // if (Auth::user()->type === 'admin') {
            //     return view('admin.detail', compact('book', 'relatedBooks', 'cart_count', 'order_count'));
            // }
        }

        return view('user.detail', compact('book', 'relatedBooks', 'cart_count', 'order_count', 'reviews', 'reviews_count', 'ratingStats', 'htmlRatingStars'));
    }

    public function search(Request $request, RecommendationService $reco)
    {
        $keyword = trim($request->input('keyword', ''));

        $query = Book::query();

        if (!empty($keyword)) {
            $query->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $books = $query->paginate(20);
        $totalBooks = $books->total();
        $categories = Book::select('category')->distinct()->get();
        $cart_count = 0;
        $order_count = 0;


        if (Auth::check()) {
            $cart_count = Cart::where('user_id', Auth::user()->id)->count();
            $order_count = Order::where('user_id', Auth::user()->id)->count();
            $recommendedBooks = $reco->recommendForUser(Auth::user()->id, 10);
            // if (Auth::user()->type === 'admin') {
            //     return view('admin.home', compact('books', 'totalBooks', 'categories', 'cart_count', 'order_count'));
            // }
        } else {
            $recommendedBooks = $reco->recommendForSession(
                session('viewed_books', []),
                10
            );
        }

        return view('user.home', compact('books', 'totalBooks', 'categories', 'cart_count', 'order_count', 'recommendedBooks'));
    }



    /**
     * Display the specified resource.
     */
    public function filter(Request $request, RecommendationService $reco)
    {
        $query = Book::query();

        if ($request->has('keyword')) {
            $query->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($request->keyword) . '%']);
        }

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $books = $query->paginate(20);
        $totalBooks = $books->total();
        $categories = Book::select('category')->distinct()->get();
        $cart_count = 0;
        $order_count = 0;

        if (Auth::check()) {
            $cart_count = Cart::where('user_id', Auth::user()->id)->count();
            $order_count = Order::where('user_id', Auth::user()->id)->count();
            $recommendedBooks = $reco->recommendForUser(Auth::user()->id, 10);
            // if (Auth::user()->type === 'admin') {
            //     return view('admin.home', compact('books', 'totalBooks', 'categories', 'cart_count', 'order_count'));
            // }
        } else {
            $recommendedBooks = $reco->recommendForSession(
                session('viewed_books', []),
                10
            );
        }
        return view('user.home', compact('books', 'totalBooks', 'categories', 'cart_count', 'order_count', 'recommendedBooks'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
