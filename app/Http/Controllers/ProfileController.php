<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Cart;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $cart_count = 0; // Mặc định giỏ hàng trống
        $cart_count = Cart::where('user_id', Auth::user()->id)->count();

        // if (Auth::check()) {
        //     $cart_count = Cart::where('user_id', Auth::user()->id)->count();
        //     if (Auth::user()->type === 'admin') {
        //         return view('admin.home', compact('books', 'totalBooks', 'categories', 'cart_count'));
        //     }
        // }
        return view('profile.edit', [
            'user' => $request->user(),
        ], compact('cart_count'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ],
        [
            'password.required' => 'Mật khẩu không được để trống.',
            'password.current_password' => 'Mật khẩu không chính xác.'
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/home');
    }
}
