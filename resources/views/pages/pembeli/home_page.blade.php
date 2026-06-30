@extends('layouts.app')

@section('title', 'Home - E-TechnoCart')

@section('content')
    <div class="max-w-7xl mx-auto px-4 md:px-6">

        <!-- Hero Section -->
        <section
            class="relative bg-gradient-to-br from-slate-700 via-slate-600 to-slate-800 h-80 md:h-96 flex items-center justify-between px-8 md:px-12 py-8 overflow-hidden rounded-3xl shadow-2xl mb-16 group transform transition-all duration-700 hover:shadow-slate-600/25">

            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 via-purple-600/5 to-red-600/10 animate-pulse">
            </div>
            <div
                class="absolute -top-10 -right-10 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl animate-bounce duration-[3000ms]">
            </div>
            <div
                class="absolute -bottom-10 -left-10 w-96 h-96 bg-red-500/15 rounded-full blur-3xl animate-pulse duration-[4000ms]">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-br from-transparent via-white/5 to-transparent rounded-3xl">
            </div>

            <div class="relative z-10 flex-1 transform transition-all duration-700 group-hover:translate-x-2">
                @if ($latestProduct)
                    <div class="mb-6">
                        <span
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-full text-xs font-semibold shadow-lg animate-bounce duration-[2000ms] hover:from-blue-600 hover:to-blue-700 transition-all cursor-default">
                            <span class="w-2 h-2 bg-white rounded-full animate-ping"></span>
                            ✨ New Arrival
                        </span>
                    </div>
                    <p
                        class="text-xl md:text-3xl font-bold text-transparent bg-gradient-to-r from-white via-blue-100 to-slate-200 bg-clip-text mb-4 leading-tight tracking-tight">
                        {{ $latestProduct->name }}
                    </p>
                    <p class="text-base md:text-lg text-blue-300 font-bold mb-8 animate-bounce duration-[1500ms] tracking-wide">
                        Latest Products Collection!
                    </p>
                    <a href="{{ route('product.show', $latestProduct->code_product) }}" class="group/btn inline-block">
                        <button
                            class="relative overflow-hidden bg-gradient-to-r from-red-600 to-red-700 text-white px-10 py-4 text-base font-bold rounded-2xl hover:from-red-700 hover:to-red-800 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-red-500/25 active:scale-95 border border-red-500/20">
                            <span class="relative z-10 flex items-center gap-3">
                                Shop Now
                                <i
                                    class='bx bx-right-arrow-alt text-lg transition-transform duration-300 group-hover/btn:translate-x-1'></i>
                            </span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700">
                            </div>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300">
                            </div>
                        </button>
                    </a>
                @endif
            </div>

            <div class="relative z-10 transform transition-all duration-700 group-hover:scale-105 group-hover:rotate-2">
                @if ($latestProduct && $latestProduct->image)
                    <div class="relative">
                        <div
                            class="absolute -inset-6 bg-gradient-to-r from-blue-600/30 via-purple-600/20 to-red-600/30 rounded-3xl blur-2xl opacity-75 animate-pulse duration-[3000ms]">
                        </div>
                        <div class="relative bg-white/10 backdrop-blur-sm rounded-3xl p-4 border border-white/20">
                            <img src="{{ asset('storage/' . $latestProduct->image) }}" alt="{{ $latestProduct->name }}"
                                class="w-48 md:w-64 lg:w-80 max-h-64 object-contain drop-shadow-2xl brightness-110 contrast-110 transition-all duration-500 hover:brightness-125" />
                        </div>
                    </div>
                @elseif ($latestProduct && $latestProduct->merk && $latestProduct->merk->logo)
                    <div class="relative">
                        <div
                            class="absolute -inset-6 bg-gradient-to-r from-blue-600/30 via-purple-600/20 to-red-600/30 rounded-3xl blur-2xl opacity-75 animate-pulse duration-[3000ms]">
                        </div>
                        <div class="relative bg-white/10 backdrop-blur-sm rounded-3xl p-4 border border-white/20">
                            <img src="{{ asset('storage/logos/' . $latestProduct->merk->logo) }}"
                                alt="{{ $latestProduct->merk->name }}"
                                class="w-48 md:w-64 lg:w-80 max-h-64 object-contain drop-shadow-2xl brightness-110 transition-all duration-500 hover:brightness-125" />
                        </div>
                    </div>
                @else
                    <div class="relative">
                        <div
                            class="absolute -inset-6 bg-gradient-to-r from-blue-600/30 via-purple-600/20 to-red-600/30 rounded-3xl blur-2xl opacity-75 animate-pulse duration-[3000ms]">
                        </div>
                        <div class="relative bg-white/10 backdrop-blur-sm rounded-3xl p-4 border border-white/20">
                            <img src="{{ asset('image/20.png') }}" alt="Default Banner"
                                class="w-48 md:w-64 lg:w-80 max-h-64 object-contain drop-shadow-2xl brightness-110 transition-all duration-500 hover:brightness-125" />
                        </div>
                    </div>
                @endif
            </div>

            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-blue-400 rounded-full animate-ping"></div>
            <div
                class="absolute top-3/4 right-1/4 w-3 h-3 bg-red-400 rounded-full animate-bounce delay-300 duration-[2000ms]">
            </div>
            <div class="absolute top-1/2 right-1/3 w-1 h-1 bg-white rounded-full animate-pulse delay-700"></div>
            <div class="absolute top-1/3 right-1/2 w-1.5 h-1.5 bg-purple-400 rounded-full animate-ping delay-1000"></div>
            <div
                class="absolute bottom-1/4 left-1/3 w-2 h-2 bg-yellow-400 rounded-full animate-bounce delay-500 duration-[1500ms]">
            </div>
        </section>

        <!-- Product Section -->
        <section class="mt-20">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-16 gap-6">
                <div class="flex-1">
                    <div class="inline-block">
                        <h3
                            class="text-2xl md:text-3xl font-bold text-transparent bg-gradient-to-r from-slate-900 via-slate-700 to-slate-800 bg-clip-text mb-4 tracking-tight">
                            Explore Products
                        </h3>
                        <div class="w-32 h-1.5 bg-gradient-to-r from-blue-600 via-purple-600 to-red-600 rounded-full"></div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <button
                        class="group p-4 bg-white hover:bg-gradient-to-br hover:from-slate-50 hover:to-slate-100 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 hover:-translate-y-1 border border-slate-200 hover:border-slate-300">
                        <i
                            class='bx bx-left-arrow-alt text-xl text-slate-600 group-hover:text-slate-800 transition-all duration-300 group-hover:-translate-x-1 group-hover:scale-110'></i>
                    </button>
                    <button
                        class="group p-4 bg-white hover:bg-gradient-to-br hover:from-slate-50 hover:to-slate-100 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 hover:-translate-y-1 border border-slate-200 hover:border-slate-300">
                        <i
                            class='bx bx-right-arrow-alt text-xl text-slate-600 group-hover:text-slate-800 transition-all duration-300 group-hover:translate-x-1 group-hover:scale-110'></i>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($products as $product)
                    @include('components.pembeli.product-card', ['product' => $product])
                @endforeach
            </div>

            <div class="mt-20 text-center">
                <div class="inline-block group relative">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-blue-600 via-purple-600 to-red-600 rounded-3xl blur-lg opacity-30 group-hover:opacity-70 transition-all duration-700 group-hover:duration-300 animate-pulse">
                    </div>
                    <a href="{{ route('products') }}" class="relative block">
                        <button
                            class="relative bg-gradient-to-r from-white via-slate-50 to-white hover:from-slate-50 hover:via-white hover:to-slate-50 px-12 py-5 rounded-3xl transition-all duration-500 transform group-hover:scale-105 border-2 border-slate-200 hover:border-slate-300 shadow-xl hover:shadow-2xl hover:shadow-slate-300/20">
                            <span
                                class="text-transparent bg-gradient-to-r from-blue-700 via-purple-700 to-red-700 bg-clip-text text-base font-semibold flex items-center justify-center gap-4 tracking-wide">
                                View All Products
                                <i
                                    class='bx bx-grid-alt text-xl transition-all duration-500 group-hover:rotate-12 group-hover:scale-125'></i>
                            </span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-600/10 via-purple-600/10 to-red-600/10 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </button>
                    </a>
                </div>
            </div>
        </section>
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-bounce {
            animation: bounce 1s infinite;
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .animate-ping {
            animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        }
    </style>
@endsection