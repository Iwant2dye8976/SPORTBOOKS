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
        $books = Book::paginate(20); // Lấy 20 sản phẩm mỗi trang
        $totalBooks = Book::count(); // Đếm tổng số sách
        $categories = Book::select('category')->distinct()->get();
        $cart_count = Cart::with('user_id', '=', Auth::user()->id)->count();
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
            ->inRandomOrder() // Chọn ngẫu nhiên
            ->limit(5)
            ->get();

        $cart_count = Cart::with('user_id', '=', Auth::user()->id)->count();
        return view('user.detail', compact('book', 'relatedBooks', 'cart_count'));
    }

    public function search(Request $request)
    {
        $keyword = $request['keyword'];
        $books = Book::whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($keyword) . '%'])->paginate(20);
        $totalBooks = Book::where('title', 'LIKE', '%' . $keyword . '%')->count();
        $categories = Book::select('category')->distinct()->get();
        $cart_count = Cart::with('user_id', '=', Auth::user()->id)->count();
        return view('user.home', compact('books', 'totalBooks', 'categories', 'cart_count'));
    }

    /**
     * Display the specified resource.
     */
    public function filter(Request $request)
    {
        // Lọc sách theo category (nếu có)
        $query = Book::query();
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        $books = $query->paginate(20); // Phân trang 10 sách mỗi trang
        $totalBooks = $books->total(); // Lấy tổng số sách
        $categories = Book::select('category')->distinct()->get();
        $cart_count = Cart::where('user_id', Auth::id())->count();

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
