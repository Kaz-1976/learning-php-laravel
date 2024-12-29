<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckNormal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // 管理者・利用者チェック
            $user = Auth::user();
            if ($user->admin_flg) {
                // チェック不通過
                return redirect(url('/admin', null, app()->isProduction()));
            }
        } else {
            // チェック不通過
            return redirect(url('/login', null, app()->isProduction()));
        }
        // チェック通過
        return $next($request);
    }
}
