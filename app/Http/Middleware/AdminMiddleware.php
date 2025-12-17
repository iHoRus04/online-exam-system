<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware kiểm tra quyền admin.
 * Nếu user chưa đăng nhập hoặc flag `is_admin` của user khác true,
 * thì middleware sẽ trả về HTTP 403.
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra session auth và flag is_admin trên model User.
        // Việc này dựa trên cột boolean `is_admin` trong bảng users.
        if (!auth()->check() || !auth()->user()->is_admin) {
            // Không cho phép truy cập nếu không phải admin.
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // Cho phép request tiếp tục nếu là admin.
        return $next($request);
    }
}
