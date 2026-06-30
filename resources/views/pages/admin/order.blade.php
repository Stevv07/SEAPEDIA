@extends('layouts.admin')

@section('title', 'Order')

@section('content')
<div class="space-y-6">
  <h2 class="text-2xl font-bold">Order Lists</h2>

  <div class="bg-white shadow rounded-lg p-4 overflow-auto">
    <table class="w-full text-left border-collapse text-sm">
      <thead>
        <tr class="bg-gray-100 text-xs uppercase text-gray-600">
          <th class="p-3">Order Code</th>
          <th class="p-3">Customer</th>
          <th class="p-3">Address</th>
          <th class="p-3">Date</th>
          <th class="p-3">Product</th>
          <th class="p-3">Category</th>
          <th class="p-3">Brands</th>
          <th class="p-3">Quantity</th>
          <th class="p-3">Payment</th>
          <th class="p-3">Proof</th>
          <th class="p-3">Total</th>
          <th class="p-3">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders->sortByDesc('created_at')->sortBy(function($order) {
            return $order->status === 'complete' ? 1 : 0;
        }) as $order)
        <tr class="border-t hover:bg-gray-50 {{ $order->status === 'complete' ? 'bg-gray-100 text-gray-500' : '' }}">
          <td class="p-3 font-medium text-blue-600">{{ $order->order_code }}</td>
          <td class="p-3">{{ $order->user->name }}</td>
          <td class="p-3">{{ $order->user->address }}</td>
          <td class="p-3">{{ $order->created_at->format('d M Y') }}</td>

          {{-- Product --}}
          <td class="p-3">
            <ul>
              @foreach($order->orderItems as $index => $item)
                <li>{{ $item->product->name ?? 'N/A' }}</li>
                @if($index < $order->orderItems->count() - 1)
                  <hr class="my-1 border-t border-gray-300">
                @endif
              @endforeach
            </ul>
          </td>

          {{-- Category --}}
          <td class="p-3">
            <ul>
              @foreach($order->orderItems as $index => $item)
                <li>{{ $item->product->category->name ?? 'N/A' }}</li>
                @if($index < $order->orderItems->count() - 1)
                  <hr class="my-1 border-t border-gray-300">
                @endif
              @endforeach
            </ul>
          </td>

          {{-- Brand --}}
          <td class="p-3">
            <ul>
              @foreach($order->orderItems as $index => $item)
                <li>{{ $item->product->merk->name ?? 'N/A' }}</li>
                @if($index < $order->orderItems->count() - 1)
                  <hr class="my-1 border-t border-gray-300">
                @endif
              @endforeach
            </ul>
          </td>

          {{-- Quantity --}}
          <td class="p-3">
            <ul>
              @foreach($order->orderItems as $index => $item)
                <li>{{ $item->quantity }}</li>
                @if($index < $order->orderItems->count() - 1)
                  <hr class="my-1 border-t border-gray-300">
                @endif
              @endforeach
            </ul>
          </td>

          <!--tambahan baru-->
          <td class="p-3">
            @if ($order->payment)
              <strong>{{ $order->payment->method_name ?? 'N/A' }}</strong><br>
              <small class="text-gray-500">{{ $order->payment->account_number }}</small>
            @else
              <strong class="text-red-600">Belum memilih metode</strong><br>
              <small class="text-gray-400">-</small>
            @endif
          </td>

          <td class="p-3">
            @if($order->payment_proof)
              <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Proof" class="w-16 h-16 object-cover rounded border">
              </a>
            @else
              <span class="text-gray-400 italic">No proof</span>
            @endif
          </td>

          <td class="p-3 font-semibold text-green-700 whitespace-nowrap">
            Rp {{ number_format($order->total_price, 0, ',', '.') }}
          </td>

          <td class="p-3">
            <form action="{{ route('order.updateStatus', $order) }}" method="POST">
              @csrf
              @php
                $statusColors = [
                  'waiting' => 'bg-yellow-200 text-yellow-800',
                  'processing' => 'bg-blue-200 text-blue-800',
                  'sent' => 'bg-purple-200 text-purple-800',
                  'complete' => 'bg-gray-300 text-gray-600',
                  'rejected' => 'bg-red-200 text-red-800',
                ];
              @endphp
              <select name="status" onchange="this.form.submit()"
                class="text-sm rounded px-2 py-1 border bg-white font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}"
                @if($order->status === 'complete') disabled @endif>
                <option value="waiting" @selected($order->status == 'waiting')>Waiting</option>
                <option value="processing" @selected($order->status == 'processing')>Processing</option>
                <option value="sent" @selected($order->status == 'sent')>Sent</option>
                <option value="complete" @selected($order->status == 'complete')>Complete</option>
                <option value="rejected" @selected($order->status == 'rejected')>Rejected</option>
              </select>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
