<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cari user berdasarkan username
        $user = user::where('username', $request->username)
                    ->where('password', $request->password) // langsung compare plain text
                    ->first();

        if ($user) {
            Auth::login($user); // simpan session login
            return redirect()->route('home'); // redirect ke home
        }

        // Jika gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/'); // kembali ke login
    }
}
