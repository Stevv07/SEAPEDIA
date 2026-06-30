<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\OtpEmail;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;


class VerificationController extends Controller
{
    public function index() {
        return view('verification.index');
    }

    public function store(Request $request) {
        if($request->type == 'register') {
            $user = User::find($request->user()->id);
        } else {
            $user = User::where('email', $request->email)->first();
        }

        if(!$user) return back()->with('failed', 'User not found.');
        $otp = rand(100000, 999999);
        $verify = Verification::create([
            'user_id' => $user->id, 'unique_id' => (string) Str::uuid(), 'otp' => md5($otp),
            'type' => $request->type, 'send_via' => 'email'
        ]);
        Mail::to($user->email)->queue(new OtpEmail($otp));
        if($verify->type == 'register') {
            return redirect('/verify/'. $verify->unique_id);
        } elseif($verify->type == 'reset_password') {
            return redirect('/reset/verify/'. $verify->unique_id)->with('success', 'OTP has been sent to your email.');
        }
    }

    public function show($unique_id) {
        $verify = Verification::where('unique_id', $unique_id)->first();
        if(!$verify) {
            abort(404);
        }
        return view('verification.show', [
            'unique_id' => $unique_id,
            'context' => $verify->type
        ]);
    }

    public function update(Request $request, $unique_id) {
        $verify = Verification::where('unique_id', $unique_id)->first();
        if(!$verify) abort(404);
        if(md5($request->otp) != $verify->otp) {
            $verify->update(['status' => 'invalid']);
            return redirect('/verify/'. $verify->unique_id)->with('failed', 'Invalid OTP');
        }
        $verify->update(['status' => 'valid']);
        if($verify->type == 'register') {
            User::find($verify->user_id)->update(['status' => 'active']);
            return redirect()->route('home_page');
        } else{
            session(['reset_user_id' => $verify->user_id]);
            return redirect()->route('password.reset')->with('success', 'OTP verified. You can now reset your password.');
        }
    }
}