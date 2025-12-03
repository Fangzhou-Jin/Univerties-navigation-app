<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 检查用户是否已登录
        if (!session('user_id')) {
            // 未登录，重定向到管理员登录页
            return redirect('/admin-login')->with('error', 'Please login as admin first');
        }

        // 检查用户是否为管理员 (role_id = 2)
        if (session('user_role') != 2) {
            // 不是管理员，重定向到普通用户页面或拒绝访问
            return redirect('/main')->with('error', 'Access denied. Admin privileges required');
        }

        return $next($request);
    }
}

