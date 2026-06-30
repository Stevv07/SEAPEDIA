@php
    $setting = \App\Models\SiteSetting::first();
@endphp
<footer class="relative bg-gradient-to-br from-slate-900 via-gray-900 to-black text-white overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl"></div>
    
    <div class="relative container mx-auto px-4 py-6">
        <!-- Main Footer Content -->
        <div class="grid lg:grid-cols-3 gap-6 mb-4">
            <!-- Brand Section -->
            <div class="space-y-2">
                <div class="group">
                    <h3 class="text-xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent mb-2 group-hover:from-purple-400 group-hover:to-blue-400 transition-all duration-300">
                        {{ optional($setting)->site_name ?? 'Site Name' }}
                    </h3>
                    <div class="w-12 h-0.5 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full group-hover:w-16 transition-all duration-300"></div>
                </div>
                @if (!empty(optional($setting)->description))
    <p class="text-gray-400 text-sm leading-relaxed mt-2 text-justify">
        {{ $setting->description }}
    </p>
@endif

            </div>
            
            <!-- Contact Info -->
            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-gray-300 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Address
                </h4>
                <div class="bg-white/5 backdrop-blur-sm rounded p-2 border border-white/10 hover:bg-white/10 transition-all duration-300">
                    <p class="text-gray-300 text-xs leading-relaxed">{{ optional($setting)->address }}</p>
                </div>
                
                <h4 class="text-sm font-semibold text-gray-300 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Contact
                </h4>
                <div class="space-y-2">
                    <div class="flex items-center space-x-2 group">
                        <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-gray-300 hover:text-white transition-colors duration-300 text-xs">{{ optional($setting)->email }}</span>
                    </div>
                    <div class="flex items-center space-x-2 group">
                        <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <span class="text-gray-300 hover:text-white transition-colors duration-300 text-xs">{{ optional($setting)->phone }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Account Navigation -->
            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-gray-300 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Account
                </h4>
                <nav class="space-y-1.5">
                    <a href="{{ route('profile') }}" class="group flex items-center space-x-2 p-2 rounded bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 hover:border-blue-400/50 transition-all duration-300">
                        <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-r from-blue-400 to-blue-500 rounded flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-gray-300 group-hover:text-white transition-colors duration-300 text-xs">My Account</span>
                        <svg class="w-3 h-3 text-gray-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-all duration-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('cart') }}" class="group flex items-center space-x-2 p-2 rounded bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 hover:border-green-400/50 transition-all duration-300">
                        <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-r from-green-400 to-green-500 rounded flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"/>
                            </svg>
                        </div>
                        <span class="text-gray-300 group-hover:text-white transition-colors duration-300 text-xs">Cart</span>
                        <svg class="w-3 h-3 text-gray-500 group-hover:text-green-400 group-hover:translate-x-1 transition-all duration-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('products') }}" class="group flex items-center space-x-2 p-2 rounded bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 hover:border-purple-400/50 transition-all duration-300">
                        <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-r from-purple-400 to-purple-500 rounded flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 12H6L5 9z"/>
                            </svg>
                        </div>
                        <span class="text-gray-300 group-hover:text-white transition-colors duration-300 text-xs">Shop</span>
                        <svg class="w-3 h-3 text-gray-500 group-hover:text-purple-400 group-hover:translate-x-1 transition-all duration-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="relative pt-8 mt-8 border-t border-gradient-to-r from-transparent via-white/20 to-transparent">
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
            <div class="text-center">
                <p class="text-gray-400 text-sm bg-black/20 backdrop-blur-sm rounded-full px-6 py-2 inline-block border border-white/10">
                    {{ optional($setting)->copyright }}
                </p>
            </div>
        </div>
    </div>
</footer>
