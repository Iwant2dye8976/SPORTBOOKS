<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $cart_count = 0;
        $order_count = 0;

        if (Auth::check()) {
            $cart_count = Cart::where('user_id', Auth::user()->id)->count();
            $order_count = Order::where('user_id', Auth::user()->id)->count();
        }

        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('home', absolute: false))
                    : view('auth.verify-email', compact('cart_count', 'order_count'));
    }
}
