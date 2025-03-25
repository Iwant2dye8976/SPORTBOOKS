<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Cart;
use App\Models\Order;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $cart_count = 0;
        $order_count = 0;
        if (Auth::check()) {
            $cart_count = Cart::where('user_id', Auth::user()->id)->count();
            $order_count = Order::where('user_id', Auth::user()->id)->whereIn('status', [-1, 0, 1])->count();
        }

        return view('profile.edit', compact('cart_count', 'order_count'))->with('user', $request->user());
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        $request->user()->save();

        return redirect()->route(Auth::user()->type === 'admin' ? 'admin.profile.edit' : 'profile.edit')->with('status', 'Cập nhật thông tin thành công');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag(
            'userDeletion',
            [
                'password' => ['required', 'current_password'],
            ],
            [
                'password.required' => 'Mật khẩu không được để trống.',
                'password.current_password' => 'Mật khẩu không chính xác.'
            ]
        );

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/home');
    }
}
