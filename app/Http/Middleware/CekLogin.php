<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string    $guard
     */
    public function handle(Request $request, Closure $next, $guard)
    {
        if (!Auth::guard($guard)->check()) {
            // Cek apakah user login di guard lain
            if (Auth::guard('admin_yayasan')->check()) {
                return redirect('/admin-yayasan')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }

            if (Auth::guard('admin_sekolah')->check()) {
                return redirect('/user-guru')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }

            if (Auth::guard('user_guru')->check()) {
                return redirect('/siswa')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }

            // Tidak login sama sekali
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
