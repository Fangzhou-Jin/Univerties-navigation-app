<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 检查用户是否已登录
        if (!session('user_id')) {
            // 未登录，重定向到用户登录页
            return redirect('/users/login')->with('error', 'Please login first');
        }

        return $next($request);
    }
}

