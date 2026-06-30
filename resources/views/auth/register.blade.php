@php($noHeader = true)

@extends('layouts.app')

@section('title', 'Register')

@section('content')

<style>
/* Hide password clear icons */
input::-ms-reveal,
input::-ms-clear,
input::-webkit-credentials-auto-fill-button,
input::-webkit-clear-button {
    display: none !important;
}
</style>

<section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200 px-4 py-8">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl flex overflow-hidden animate__animated animate__fadeInUp">
        <!-- Left Image (Hidden on small screens) -->
        <div class="hidden lg:flex items-center justify-center w-1/2 bg-blue-200">
            <img src="/image/produk.png" alt="Electronics" class="object-contain w-4/5 animate__animated animate__fadeInLeft">
        </div>

        <!-- Register Form -->
        <div class="w-full lg:w-1/2 p-10 relative bg-[#fefefe]">
            <!-- Title -->
            <h2 class="text-3xl font-bold text-blue-600 text-center mb-2 animate__animated animate__fadeInDown">Create Account</h2>
            <p class="text-sm text-gray-500 text-center mb-6">Enter your details to register</p>

            <!-- Flash Messages -->
            @if (session('failed'))
                <div class="text-red-700 mb-4 text-center font-medium">{{ session('failed') }}</div>
            @endif
            @if (session('success'))
                <div class="text-green-700 mb-4 text-center font-medium">{{ session('success') }}</div>
            @endif

            <!-- Register Form -->
            <form action="{{ route('dataRegister') }}" method="POST" class="space-y-6 animate__animated animate__fadeInUp">
                @csrf

                <!-- Email -->
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                        class="w-full py-3 px-4 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500 text-sm">
                    <i class='bx bx-envelope absolute right-4 top-1/2 -translate-y-1/2 text-gray-500'></i>
                </div>
                @error('email')
                    <small class="text-red-700">{{ $message }}</small>
                @enderror

                <!-- Password -->
                <div class="relative">
                    <input id="password" type="password" name="password" placeholder="Password"
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
                    <input id="confirm-password" type="password" name="confirm-password" placeholder="Confirm Password"
                        class="w-full py-3 px-4 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500 text-sm">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer show-confirm-password text-gray-500">
                        <i id="confirm-password-lock" class="bx bx-lock"></i>
                    </span>
                </div>
                @error('confirm-password')
                    <small class="text-red-700">{{ $message }}</small>
                @enderror

                <!-- Submit -->
                <div class="flex justify-between items-center">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 transition-colors text-white px-6 py-3 rounded-lg shadow-md font-semibold text-sm">
                        Register
                    </button>
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:underline">Already have an account?</a>
                </div>
            </form>

            <!-- Extra link if needed -->
            <p class="text-sm text-gray-600 mt-6 text-center">Already have an account?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login</a>
            </p>
        </div>
    </div>
</section>

<!-- Animations (Animate.css) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<!-- Show/hide password script -->
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