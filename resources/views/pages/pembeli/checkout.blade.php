@extends('layouts.app')

@section('content')
<nav class="text-sm text-gray-600 px-14 mt-4 py-2">
  <a href="{{ route('home_page') }}" class="hover:underline text-blue-600">Home</a> /
  <a href="{{ route('cart') }}" class="hover:underline text-blue-600">Cart</a> /
  <span class="text-gray-800 font-medium">Checkout</span>
</nav>

<section class="bg-gray-50 py-10">
  <div class="container mx-auto px-4 flex flex-col lg:flex-row gap-8">
    <form action="{{ route('checkout.to_payment') }}" method="POST" class="w-full flex flex-col lg:flex-row gap-8">
      @csrf
      @foreach(request('selected_items', []) as $id)
        <input type="hidden" name="selected_items[]" value="{{ $id }}">
      @endforeach

      <!-- Billing Details -->
      <div class="w-full lg:w-2/3 bg-white p-8 rounded-2xl shadow-md border">
        <h2 class="text-2xl font-bold mb-6 text-blue-700 flex items-center gap-2">
          <i class="fas fa-user-circle"></i> Billing Details
        </h2>
        <div class="space-y-5">
          <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Name</label>
            <input type="text" value="{{ $user->name }}" class="w-full border rounded-lg p-3 bg-gray-100" readonly>
          </div>
          <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Address</label>
            <input type="text" value="{{ $user->address }}" class="w-full border rounded-lg p-3 bg-gray-100" readonly>
          </div>
          <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Phone Number</label>
            <input type="text" value="{{ $user->phone }}" class="w-full border rounded-lg p-3 bg-gray-100" readonly>
          </div>
          <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" value="{{ $user->email }}" class="w-full border rounded-lg p-3 bg-gray-100" readonly>
          </div>
        </div>
      </div>

      <!-- Order Summary -->
      <div class="w-full lg:w-1/3 bg-white p-8 rounded-2xl shadow-md border">
        <h2 class="text-xl font-semibold mb-4 text-blue-700 flex items-center gap-2">
          <i class="fas fa-shopping-cart"></i> Order Summary
        </h2>
        <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2">
          @foreach ($cart as $item)
          <div class="flex items-center justify-between border-b pb-2">
            <div class="flex items-center gap-3">
              <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->product_name }}"
                class="w-12 h-12 rounded-md object-cover">
              <div>
                <p class="font-medium text-sm">{{ $item->product->name }}</p>
                <p class="text-xs text-gray-500">x {{ $item->quantity }}</p>
              </div>
            </div>
            <span class="text-sm font-semibold text-gray-700">
              Rp {{ number_format($item->subtotal, 0, ',', '.') }}
            </span>
          </div>
          @endforeach
        </div>

        <div class="border-t pt-4 space-y-2">
          <div class="flex justify-between font-semibold text-lg text-gray-800 pt-2">
            <span>Total:</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
          </div>
        </div>

        <button type="submit"
          class="mt-6 w-full bg-blue-600 hover:bg-blue-700 transition text-white font-semibold py-3 rounded-lg shadow">
          Place Order
        </button>
      </div>
    </form>
  </div>
</section>

<!-- Profile Warning Popup -->
@if($showProfileWarning)
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl text-center shadow-2xl max-w-md w-full">
      <h2 class="text-xl font-bold text-red-600 mb-4">Complete Your Profile</h2>
      <p class="text-gray-700 mb-6">Please complete your profile information before continuing.</p>
      <a href="{{ route('profile') }}"
         class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold transition">
        Complete Now
      </a>
    </div>
  </div>
@endif

@endsection
