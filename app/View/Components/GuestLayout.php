<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // return view('layouts.app');
        //return view('user.home');
        $books = Book::paginate(20);
        $totalBooks = Book::count();
        $categories = Book::select('category')->distinct()->get();

        $cart_count = 0;
        $order_count = 0;

        if (Auth::check()) {
            $cart_count = Cart::where('user_id', Auth::user()->id)->count();
            $order_count = Order::where('user_id', Auth::user()->id)->count();
        }

        return view('user.home', compact('books', 'totalBooks', 'categories', 'cart_count', 'order_count'));
    }
}
