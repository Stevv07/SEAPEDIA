@extends('layouts.admin')

@section('title', 'Sales Report')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Sales Report</h2>

    {{-- Filter --}}
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 bg-gray-50 p-4 rounded-lg shadow-sm">
        <div class="flex flex-col">
            <label for="start_date" class="text-sm text-gray-700 mb-1">Start Date</label>
            <input type="date" name="start_date" id="start_date"
                value="{{ request('start_date') }}"
                class="border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="flex flex-col">
            <label for="end_date" class="text-sm text-gray-700 mb-1">End Date</label>
            <input type="date" name="end_date" id="end_date"
                value="{{ request('end_date') }}"
                class="border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="flex flex-col">
            <label for="category" class="text-sm text-gray-700 mb-1">Category</label>
            <select name="category" id="category"
                class="border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Category</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->code }}" {{ request('category') == $cat->code ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end gap-2">
    <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow transition">
        🔍 Filter
    </button>
    <a href="{{ route('sales.report') }}"
        class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md shadow transition text-center">
        ❌ Reset
    </a>
</div>

    </form>

    @if($sales->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded-md">
            Tidak ada data penjualan.
        </div>
    @else
        <div class="overflow-x-auto shadow rounded-lg">
            <table class="min-w-full text-sm text-left text-gray-700 bg-white border border-gray-200 rounded-md overflow-hidden">
                <thead class="bg-blue-100 text-gray-800 font-semibold">
                    <tr>
                        <th class="px-4 py-3 border">Date</th>
                        <th class="px-4 py-3 border">Order Code</th>
                        <th class="px-4 py-3 border">Product</th>
                        <th class="px-4 py-3 border">Category</th>
                        <th class="px-4 py-3 border">Brand</th>
                        <th class="px-4 py-3 border">Quantity</th>
                        <th class="px-4 py-3 border">Base Price</th>
                        <th class="px-4 py-3 border">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalSales = 0;
                        $previousOrderCode = null;
                        $previousDate = null;
                    @endphp

                    @foreach ($sales as $sale)
                        @php
                            $product = $sale->product;
                            $basePrice = $product->price ?? 0;
                            $subtotal = $basePrice * $sale->quantity;
                            $totalSales += $subtotal;
                            $currentDate = \Carbon\Carbon::parse($sale->order->created_at)->format('d M Y');
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="border px-4 py-2">
                                @if ($sale->order_code !== $previousOrderCode)
                                    {{ $currentDate }}
                                    @php $previousOrderCode = $sale->order_code; @endphp
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $sale->order_code }}</td>
                            <td class="border px-4 py-2">{{ $product->name ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $product->category->name ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $product->merk->name ?? '-' }}</td>
                            <td class="border px-4 py-2 text-center">{{ $sale->quantity }}</td>
                            <td class="border px-4 py-2">
                                Rp {{ number_format($basePrice, 0, ',', '.') }}
                            </td>
                            <td class="border px-4 py-2 text-green-700 font-semibold">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach

                    <tr class="bg-gray-100 font-bold text-gray-900">
                        <td colspan="7" class="border px-4 py-3 text-right">Total Penjualan</td>
                        <td class="border px-4 py-3 text-green-800">
                            Rp {{ number_format($totalSales, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    {{-- Tombol Print --}}
    <div class="mt-6 text-right print:hidden">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-5 rounded-lg shadow transition">
            🖨️ Print
        </button>
    </div>
</div>
@endsection
