<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Deliverer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        }

        if (Auth::user()->type === 'deliverer') {
            return $next($request);
        }

        return redirect()->route('delivery.orders-m')->with('error', 'Bạn không có quyền truy cập!');
        // return $next($request);
    }
}
