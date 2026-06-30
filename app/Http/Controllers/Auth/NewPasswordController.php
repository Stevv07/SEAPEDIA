<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;

class NewPasswordController extends Controller
{
    public function create()
    {
        $userId = session('reset_user_id');
        if (!$userId) {
            return redirect()->route('login')->with('failed', 'Akses tidak valid.');
        }

        $user = User::findOrFail($userId);
        return view('auth.reset-password', ['email' => $user->email]);
        }

    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|max:50|min:8',
            'password_confirmation' => 'required|max:50|min:8|same:password',
        ]);

        $user_id = session('reset_user_id');
        if (!$user_id) {
            return redirect()->route('password.reset')->withErrors(['expired' => 'Sesi reset tidak ditemukan atau sudah kadaluarsa.']);
        }

        $user = User::findOrFail($user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget('reset_user_id');

        return redirect()->route('login')->with('success', 'Password berhasil diperbarui.');
    }

    public function reset(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $token = Password::createToken($user);
        session(['reset_user_id' => $user->id]);

        return redirect()->route('password.reset')->with('success', 'Link reset password telah dikirim ke email Anda.');
    }
}