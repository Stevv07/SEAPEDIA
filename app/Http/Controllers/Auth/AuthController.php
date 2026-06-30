<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // Tampilkan halaman register
    public function tampilRegister() {
        return view('auth.register');
    }

    // Proses registrasi
    public function dataRegister(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|max:100',
            'password' => 'required|max:50|min:8',
            'confirm-password' => 'required|max:50|min:8|same:password',
        ]);

        // Cek apakah email sudah terdaftar
        $email = User::where('email', $request->email)->first();
        if ($email) {
            return back()->with('failed', 'Email sudah terdaftar');
        }

        

        $request['status'] = 'verify';
        $user = User::create($request->all());
        Auth::login($user);

        return redirect()->route('verify');
    }

    // Tampilkan halaman login
    public function tampilLogin() {
        return view('auth.login');
    }

    // Proses login
    public function dataLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:100',
            'password' => 'required|max:50'
        ]);

        if(Auth::attempt($request->only('email', 'password'), $request->remember)) {
            if(Auth::user()->role == 'pembeli') {
                return redirect()->route('home_page');
            }
            return redirect()->route('dashboard');
        }
        return back()->with('failed', 'Email atau password salah');
    }

    // Logout
    public function logout(Request $request) {
        Auth::logout();
        Session::flush();
        return redirect()->route('login')->with('success', 'Anda telah logout');
    }
}