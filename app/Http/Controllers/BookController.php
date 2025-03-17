<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getall()
    {
        $books = Book::paginate(20);
        $totalBooks = Book::count();
        $categories = Book::select('category')->distinct()->get();

        $cart_count = 0; // Mặc định giỏ hàng trống

        if (Auth::check()) {
            $cart_count = Cart::where('user_id', Auth::user()->id)->count();
            if (Auth::user()->type === 'admin') {
                return view('admin.home', compact('books', 'totalBooks', 'categories', 'cart_count'));
            }
        }

        return view('user.home', compact('books', 'totalBooks', 'categories', 'cart_count'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function getDetail($id)
    {
        $book = Book::findOrFail($id);

        // Lấy 5 quyển sách cùng thể loại nhưng không trùng với sách hiện tại
        $relatedBooks = Book::where('category', $book->category)
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $cart_count = Auth::check() ? Cart::where('user_id', Auth::id())->count() : 0;

        // Kiểm tra nếu là admin thì có thể điều hướng sang một trang khác
        if (Auth::check() && Auth::user()->type === 'admin') {
            return view('admin.detail', compact('book', 'relatedBooks', 'cart_count'));
        }

        return view('user.detail', compact('book', 'relatedBooks', 'cart_count'));
    }



    public function search(Request $request)
    {
        $keyword = trim($request->input('keyword', ''));

        $query = Book::query();

        if (!empty($keyword)) {
            $query->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $books = $query->paginate(20);
        $totalBooks = $books->total();
        $categories = Book::select('category')->distinct()->get();

        $cart_count = Auth::check() ? Cart::where('user_id', Auth::id())->count() : 0;

        if (Auth::check() && Auth::user()->type === 'admin') {
            return view('admin.home', compact('books', 'totalBooks', 'categories', 'cart_count'));
        }

        return view('user.home', compact('books', 'totalBooks', 'categories', 'cart_count'));
    }



    /**
     * Display the specified resource.
     */
    public function filter(Request $request)
    {
        $query = Book::query();

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $books = $query->paginate(20);
        $totalBooks = $books->total();
        $categories = Book::select('category')->distinct()->get();

        $cart_count = Auth::check() ? Cart::where('user_id', Auth::id())->count() : 0;

        if (Auth::check() && Auth::user()->type === 'admin') {
            return view('admin.home', compact('books', 'totalBooks', 'categories', 'cart_count'));
        }

        return view('user.home', compact('books', 'totalBooks', 'categories', 'cart_count'));
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
