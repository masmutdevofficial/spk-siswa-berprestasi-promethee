<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginSelector()
    {
        return view('auth.login');
    }

    public function showAdminYayasanLoginForm()
    {
        return view('auth.login-admin-yayasan');
    }

    public function showAdminSekolahLoginForm()
    {
        return view('auth.login-admin-sekolah');
    }

    public function showGuruLoginForm()
    {
        return view('auth.login-guru');
    }

    public function loginAdminYayasan(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin_yayasan')->attempt($credentials)) {
            session([
                'role' => 'admin_yayasan',
                'user_id' => Auth::guard('admin_yayasan')->id(),
            ]);

            return redirect('/admin-yayasan');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function loginAdminSekolah(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin_sekolah')->attempt($credentials)) {
            session([
                'role' => 'admin_sekolah',
                'user_id' => Auth::guard('admin_sekolah')->id(),
            ]);

            return redirect('/user-guru');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function loginGuru(Request $request)
    {
        $credentials = $request->only('email', 'password');


        if (Auth::guard('user_guru')->attempt($credentials)) {
            session([
                'role' => 'user_guru',
                'user_id' => Auth::guard('user_guru')->id(),
            ]);
            return redirect('/siswa');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin_yayasan')->logout();
        Auth::guard('admin_sekolah')->logout();
        Auth::guard('user_guru')->logout();

        session()->flush();
        return redirect()->route('login');
    }
}
