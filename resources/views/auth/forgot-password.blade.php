@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200 px-4 py-8">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl flex overflow-hidden animate__animated animate__fadeInUp">
        <!-- Left Image -->
        <div class="hidden lg:flex items-center justify-center w-1/2 bg-blue-200">
            <img src="/image/produk.png" alt="Electronics" class="object-contain w-4/5 animate__animated animate__fadeInLeft">
        </div>

        <!-- Forgot Password Form -->
        <div class="w-full lg:w-1/2 p-10 relative bg-[#fefefe]">
            <h2 class="text-3xl font-bold text-blue-600 text-center mb-2 animate__animated animate__fadeInDown">Forgot Password</h2>
            <p class="text-sm text-gray-500 text-center mb-6">Enter your email to reset your password</p>

            @if (session('failed'))
                <div class="text-red-700 text-center mb-4 font-medium">{{ session('failed') }}</div>
            @endif
            @if (session('status'))
                <div class="text-green-700 text-center mb-4 font-medium">{{ session('status') }}</div>
            @endif

            <form method="POST" action="/reset/verify" class="space-y-6 animate__animated animate__fadeInUp">
                @csrf
                <input type="hidden" name="type" value="reset_password">

                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                        class="w-full py-3 px-4 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500 text-sm" required>
                    <i class='bx bx-envelope absolute right-4 top-1/2 -translate-y-1/2 text-gray-500'></i>
                </div>
                @error('email')
                    <small class="text-red-700">{{ $message }}</small>
                @enderror

                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 transition-colors text-white px-6 py-3 rounded-lg shadow-md font-semibold text-sm">
                        Continue
                    </button>
                </div>
            </form>

            <p class="text-sm text-gray-600 mt-6 text-center">Back to
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login</a>
            </p>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection
