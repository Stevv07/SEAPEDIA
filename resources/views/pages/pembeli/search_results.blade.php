@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
{{-- Breadcrumb --}}
<div class="container mx-auto px-6 py-6 text-gray-600 text-sm">
    <a href="{{ route('home_page') }}" class="text-blue-600 hover:underline">Home</a>
    / Search: "{{ $query }}"
</div>

{{-- Main Content --}}
<main class="container mx-auto px-6 py-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
    @if($products->count())
        @foreach($products as $product)
            @include('components.pembeli.product-card', ['product' => $product])
        @endforeach
    @else
        <div class="col-span-full text-gray-600">
            No products found.
        </div>
    @endif
</main>
@endsection
