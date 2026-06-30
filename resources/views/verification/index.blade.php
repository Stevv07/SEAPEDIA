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
        <div class="w-full lg:w-1/2 p-10 relative bg-[#fefefe] mt-20">
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

            <form action="/verify" method="post" class="mt-4">
                @csrf
                <input type="hidden" value="register" name="type">
                
                <div class="flex justify-center">
                    <button type="submit" class="bg-[#70B9EA] text-white py-3 px-5 w-48 rounded-md text-center text-sm hover:bg-blue-600 transition-colors">
                        Send OTP to your email
                    </button>
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