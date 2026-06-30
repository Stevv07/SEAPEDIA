@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')

<style>
input::-ms-reveal,
input::-ms-clear,
input::-webkit-credentials-auto-fill-button,
input::-webkit-clear-button {
    display: none !important;
}
</style>

<section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200 px-4 py-8">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl flex overflow-hidden animate__animated animate__fadeInUp">
        <!-- Left Image -->
        <div class="hidden lg:flex items-center justify-center w-1/2 bg-blue-200">
            <img src="/image/produk.png" alt="Electronics" class="object-contain w-4/5 animate__animated animate__fadeInLeft">
        </div>

        <!-- Reset Form -->
        <div class="w-full lg:w-1/2 p-10 relative bg-[#fefefe]">
            <h2 class="text-3xl font-bold text-blue-600 text-center mb-2 animate__animated animate__fadeInDown">Reset Password</h2>
            <p class="text-sm text-gray-500 text-center mb-6">Enter your new password</p>

            @if(session('success'))
                <p class="text-green-600 text-sm text-center">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6 animate__animated animate__fadeInUp">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- New Password -->
                <div class="relative">
                    <input id="password" type="password" name="password" placeholder="New Password"
                        class="w-full py-3 px-4 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500 text-sm">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer show-password text-gray-500">
                        <i id="password-lock" class="bx bx-lock"></i>
                    </span>
                </div>
                @error('password')
                    <small class="text-red-700">{{ $message }}</small>
                @enderror

                <!-- Confirm Password -->
                <div class="relative">
                    <input id="confirm-password" type="password" name="password_confirmation" placeholder="Confirm Password"
                        class="w-full py-3 px-4 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500 text-sm">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer show-confirm-password text-gray-500">
                        <i id="confirm-password-lock" class="bx bx-lock"></i>
                    </span>
                </div>
                @error('password_confirmation')
                    <small class="text-red-700">{{ $message }}</small>
                @enderror

                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 transition-colors text-white px-6 py-3 rounded-lg shadow-md font-semibold text-sm">
                        Continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function () {
        $('.show-password').on('click', function () {
            const input = $('#password');
            const icon = $('#password-lock');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bx-lock').addClass('bx-lock-open');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bx-lock-open').addClass('bx-lock');
            }
        });

        $('.show-confirm-password').on('click', function () {
            const input = $('#confirm-password');
            const icon = $('#confirm-password-lock');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bx-lock').addClass('bx-lock-open');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bx-lock-open').addClass('bx-lock');
            }
        });
    });
</script>

@endsection
