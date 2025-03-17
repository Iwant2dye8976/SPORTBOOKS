<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Nếu chưa đăng nhập, chuyển hướng về trang chủ
        if (!Auth::check()) {
            return redirect()->route('home');
        }

        // Nếu là admin, cho phép truy cập
        if (Auth::user()->type === 'admin') {
            return $next($request);
        }

        // Nếu không phải admin, chuyển hướng về trang user
        return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập!');
    }
}
