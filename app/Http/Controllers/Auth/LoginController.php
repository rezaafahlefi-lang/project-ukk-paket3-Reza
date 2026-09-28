<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Memproses form login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required', // Bisa berisi username admin atau nis siswa
            'password' => 'required',
        ]);

        $credentials = [
            'password' => $request->password,
        ];

        // 1. Coba login sebagai Admin
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard'); // Nanti kita buat route ini
        }

        // 2. Jika bukan admin, coba login sebagai Siswa (gunakan username sebagai NIS)
        if (Auth::guard('siswa')->attempt(['nis' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('siswa.dashboard'); // Nanti kita buat route ini
        }

        // Jika keduanya gagal
        return back()->withErrors([
            'username' => 'Username/NIS atau password salah.',
        ])->onlyInput('username');
    }

    // Memproses logout
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}