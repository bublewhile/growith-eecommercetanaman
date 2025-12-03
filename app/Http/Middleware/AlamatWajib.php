<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlamatWajib
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Kalau user login tapi alamat kosong
        if ($user && empty($user->alamat)) {
            // arahkan balik ke summary order dengan pesan
            return redirect()->route('orders.summary', $request->route('orderId'))
                ->with('success_message', 'Lengkapi alamat dulu sebelum checkout.');
        }

        return $next($request);
    }
}
