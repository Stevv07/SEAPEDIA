@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-300 to-blue-400 px-6 py-5">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm0 0v1m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Change Password
            </h2>
            <p class="text-blue-100 text-sm mt-1">Update your account password securely</p>
        </div>

        <div class="p-6 sm:p-8">
            <!-- Back to Profile Button -->
            <div class="mb-6">
                <a href="{{ route('profile') }}" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Profile
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <h4 class="text-red-800 font-medium mb-2">Please fix the following errors:</h4>
                            <ul class="text-red-700 space-y-1 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start gap-2">
                                        <span class="w-1 h-1 bg-red-500 rounded-full mt-2 flex-shrink-0"></span>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('change.password.update') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Current Password -->
                <div class="space-y-1">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input 
                        type="password" 
                        name="current_password" 
                        id="current_password" 
                        required
                        class="w-full px-4 py-3 bg-[#e8dedd] border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-500 text-sm"
                        placeholder="Enter current password"
                    />
                </div>

                <!-- New Password -->
                <div class="space-y-1">
                    <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input 
                        type="password" 
                        name="new_password" 
                        id="new_password" 
                        required
                        class="w-full px-4 py-3 bg-[#e8dedd] border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-500 text-sm"
                        placeholder="Enter new password"
                    />
                </div>

                <!-- Confirm New Password -->
                <div class="space-y-1">
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input 
                        type="password" 
                        name="new_password_confirmation" 
                        id="new_password_confirmation" 
                        required
                        class="w-full px-4 py-3 bg-[#e8dedd] border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-500 text-sm"
                        placeholder="Repeat new password"
                    />
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-5 py-3 bg-blue-600 text-white font-semibold text-sm rounded-xl hover:bg-blue-700 transition duration-200"
                    >
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
