<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('pages.pembeli.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->name    = $validated['name'];
        $user->phone   = $validated['phone'];
        $user->address = $validated['address'];
        $user->save();

        $redirectTo = session('redirect_after_profile', route('profile'));
        session()->forget('redirect_after_profile');

        return redirect($redirectTo)->with('success', 'Profil Anda berhasil diperbarui. Silakan lanjutkan proses belanja Anda.');
    }
}