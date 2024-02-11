<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;

class checkSessionExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sessionLifetime = config('session.lifetime') * 60; // Konversi menit ke detik
        $lastActivity = Session::get('last_activity');

        if ($lastActivity && time() - $lastActivity > $sessionLifetime) {
            // Sesi sudah kedaluwarsa, arahkan ke halaman login
            Session::flush();
            return redirect('/login-user')->with('error', 'Sesi Anda telah kedaluwarsa. Silakan login kembali.');
        }

        // Simpan waktu aktivitas terakhir
        Session::put('last_activity', time());

        return $next($request);
    }
}
