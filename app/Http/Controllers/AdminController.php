<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function book_m()
    {
        $books = Book::paginate(10);
        $book_count = Book::get()->count();
        return view('admin.index', compact('books', 'book_count'));
    }

    public function user_m()
    {
        $users = User::whereNotIn('id', [Auth::user()->id])->paginate(10);
        return view('admin.index', compact('users'));
    }

    public function order_m()
    {
        $orders = Order::with('user')->paginate(10);
        $order_count = Order::all()->count();
        return view('admin.index', compact('orders', 'order_count'));
    }

    public function order_m_show(Request $request)
    {
        $product_count = OrderDetail::where('order_id', $request->id)->count();
        $order_details = OrderDetail::with('book')->where('order_id', $request->id)->get();
        $order_information = Order::with('user')->where('id', $request->id)->first();
        return view('admin.index', compact('product_count', 'order_details', 'order_information'));
    }

    public function book_m_show(Request $request, $id)
    {
        $book = Book::where('id', $id)->first();
        return view('admin.index', compact('book'));
    }

    public function book_m_update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'min:1', 'numeric'],
            'image_url' => ['required', 'string'],
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề sách.',
            'title.string' => 'Tiêu đề sách phải là chuỗi ký tự.',
            'title.max' => 'Tiêu đề sách không được vượt quá 255 ký tự.',

            'author.required' => 'Vui lòng nhập tên tác giả.',
            'author.string' => 'Tên tác giả phải là chuỗi ký tự.',
            'author.max' => 'Tên tác giả không được vượt quá 255 ký tự.',

            'category.required' => 'Vui lòng chọn danh mục sách.',
            'category.string' => 'Danh mục sách phải là chuỗi ký tự.',

            'description.required' => 'Vui lòng nhập mô tả sách.',
            'description.string' => 'Mô tả sách phải là chuỗi ký tự.',

            'price.required' => 'Vui lòng nhập giá sách.',
            'price.numeric' => 'Giá sách phải là một số.',
            'price.min' => 'Giá sách phải lớn hơn hoặc bằng 1.',

            'image_url.required' => 'Vui lòng nhập đường dẫn ảnh.',
            'image_url.string' => 'Đường dẫn ảnh phải là chuỗi ký tự.',
        ]);

        $book = Book::where('id', $id)->first();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->category = $request->category;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->image_url = $request->image_url;
        $book->save();
        return redirect()->back()->with('success', 'Cập nhật thông tin sách thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroyBook(Request $request, $id)
    {
        $book = Book::where('id', $id)->first();
        $book->delete();
        return redirect()->back()->with('success', 'Sách đã bị xóa.');
    }

    public function destroyUser(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();
        return redirect()->back()->with('success', 'Tài khoản đã bị xóa.');
    }
}
