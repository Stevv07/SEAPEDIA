@php($noHeader = true)

@extends('layouts.app')

@section('title', 'Login')

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

        <!-- Verification Form -->
        <div class="w-full lg:w-1/2 p-10 relative bg-[#fefefe]">
            <!-- Title -->
            <h2 class="text-3xl font-bold text-blue-600 text-center mb-2 animate__animated animate__fadeInDown">Verification</h2>
            <p class="text-sm text-gray-500 text-center mb-6">Please verify your account</p>

            <!-- Flash Messages -->
            @if (session('failed'))
                <div class="text-red-700 mb-4 text-center font-medium">{{ session('failed') }}</div>
            @endif
            @if (session('success'))
                <div class="text-green-700 mb-4 text-center font-medium">{{ session('success') }}</div>
            @endif

            <form action="{{ $context === 'reset_password' ? route('reset.update', $unique_id) : route('verify.update', $unique_id) }}" method="post" class="space-y-8 mt-12">
                @method('PUT')
                @csrf
                <div class="relative">
                    <input type="text" name="otp" placeholder="Enter OTP" class="w-full py-2 px-3 pr-10 bg-transparent border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-800 placeholder-gray-500">
                    <i class='bx bx-envelope-open absolute right-3 top-1/2 -translate-y-1/2 text-gray-500'></i>
                </div>
                @error('otp')
                <small class="text-red-700">{{ $message }}</small>
                @enderror
                <div class="flex justify-between space-x-4 items-center w-full">
                    <button class="bg-[#70B9EA] text-white py-3 px-5 w-32 rounded-md text-center text-sm hover:bg-blue-600 transition-colors">Submit</button>
                </div>
            </form>

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
    });
</script>

@endsection