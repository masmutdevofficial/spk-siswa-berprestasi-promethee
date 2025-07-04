<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class SudahLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin_yayasan')->check()) {
            return redirect('/admin-yayasan');
        }

        if (Auth::guard('admin_sekolah')->check()) {
            return redirect('/user-guru');
        }

        if (Auth::guard('user_guru')->check()) {
            return redirect('/siswa');
        }

        return $next($request);
    }
}
