<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    // Menampilkan halaman register
    public function tampilRegister() {
        return view('pages.pembeli.register');
    }
}
