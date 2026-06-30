@extends('layouts.app')

@section('title', 'viewAll')

@section('content')
<div class="container mx-auto px-6 py-6 text-gray-600 text-sm">
    <a href="{{ route('home_page') }}" class="text-blue-600 hover:underline">Home</a>
            / Product
</div>

<main class="container mx-auto px-6 py-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
    @foreach($dataProduk as $produk)
        @include('components.pembeli.product-card', ['product' => $produk])
    @endforeach
</main>
@endsection
