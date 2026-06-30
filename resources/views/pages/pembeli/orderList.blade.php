@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="flex flex-col md:flex-row gap-8 md:gap-12 mt-6">
  
  <!-- Sidebar Kiri -->
  <div class="w-full md:w-1/3 flex flex-col justify-start items-start gap-8 px-4 md:px-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-3">
      <a href="{{ route('home_page') }}" class="text-black hover:underline opacity-50">Home</a>
      <div class="h-4 border-l border-gray-500 opacity-70 rotate-45"></div>
      <a href="{{ route('profile') }}" class="text-black hover:underline">My Account</a>
    </div>

    <!-- Menu -->
    <div class="flex flex-col items-start gap-6">
      <div>
        <span class="text-black font-semibold">Manage My Account</span>
        <a href="{{ route('profile') }}" class="text-blue-500 hover:underline block">My Profile</a>
        <a href="{{ route('change.password') }}" class="text-blue-500 hover:underline block">Change Password</a>
      </div>

      <div>
        <span class="text-black font-semibold">My Orders</span>
        <a href="{{ route('order.list') }}" class="text-blue-500 hover:underline block">List Order</a>
      </div>
    </div>
  </div>

  <!-- Konten Kanan -->
  <div class="w-full md:w-2/3 space-y-6 px-4 md:px-0">
    <h2 class="text-2xl font-bold">My Order</h2>

    <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
      <table class="w-full text-left border-collapse text-sm">
        <thead>
          <tr class="bg-gray-100 text-xs uppercase text-gray-600">
            <th class="p-3">Product</th>
            <th class="p-3">Total</th>
            <th class="p-3">Status</th>
            <th class="p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($orders as $order)
          <tr class="border-t hover:bg-gray-50">
            <td class="p-3">
              <ul class="space-y-2">
                @foreach($order->orderItems as $item)
                <li class="flex items-center gap-2">
                  <img src="{{ asset('storage/'. $item->product->image ?? 'placeholder.png') }}" alt="{{ $item->product->name }}" class="w-10 h-10 object-cover rounded">
                  <div>
                    <div>{{ $item->product->name ?? 'N/A' }}</div>
                    <div class="text-xs text-gray-500">x{{ $item->quantity }}</div>
                  </div>
                </li>
                @endforeach
              </ul>
            </td>

            <td class="p-3 font-semibold text-green-700 whitespace-nowrap">
              Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </td>

            <td class="p-3 capitalize">
              <span class="px-2 py-1 rounded
                @switch($order->status)
                  @case('pending_payment') bg-orange-100 text-orange-800 @break
                  @case('waiting') bg-yellow-100 text-yellow-800 @break
                  @case('processing') bg-blue-100 text-blue-800 @break
                  @case('sent') bg-purple-100 text-purple-800 @break
                  @case('complete') bg-green-100 text-green-800 @break
                  @case('rejected') bg-red-100 text-red-800 @break
                @endswitch
              ">
                {{ $order->status }}
              </span>
            </td>

            <td class="p-3">
              @if($order->status === 'pending_payment')
                <a href="{{ route('payment.page', ['order_code' => $order->order_code]) }}"
                  class="text-red-600 hover:underline">
                  Pay Now
                </a>
              @else
                <a href="{{ route('order.invoice', $order->order_code) }}" class="text-blue-600 hover:underline">
                  Details
                </a>
              @endif
            </td>
          </tr>

          <!-- Resi Detail -->
          <tr id="resi-{{ $order->order_code }}" class="hidden">
            <td colspan="4" class="p-3 bg-gray-50 text-sm text-gray-700">
              <strong>Resi Pengiriman:</strong> {{ $order->resi ?? 'Belum tersedia' }}
            </td>
          </tr>

          @empty
          <tr>
            <td colspan="4" class="text-center text-gray-500 py-4">No orders found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  function toggleResi(code) {
    const row = document.getElementById('resi-' + code);
    row.classList.toggle('hidden');
  }
</script>
@endsection
