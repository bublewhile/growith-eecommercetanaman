<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isGuest
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kalau belum login, lanjut akses halaman login/signup
        if (!Auth::check()) {
            return $next($request);
        }

        // Kalau sudah login, munculkan alert dan kembali
        return response("<script>alert('No Access Permit'); window.history.back();</script>");
    }
}
