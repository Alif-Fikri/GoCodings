<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Mencoba untuk login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Jika login berhasil, redirect ke halaman yang diminta atau ke halaman utama
            return redirect()->intended('/');
        }

        // Jika login gagal, kembali ke form login dengan pesan error
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // Proses logout
    public function logout()
    {
        Auth::logout(); // Logout user
        return redirect('/login'); // Redirect ke halaman login setelah logout
    }
}
