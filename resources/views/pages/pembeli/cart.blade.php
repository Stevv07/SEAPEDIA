@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<nav class="text-sm text-gray-600 px-4 md:px-14 mt-4 py-2">
    <a href="{{ route('home_page') }}" class="hover:underline text-blue-600">Home</a> /
    <span class="text-gray-800 font-medium">Cart</span>
</nav>

@if($cart->isEmpty())
<div class="text-center text-gray-600 py-20">
    <h2 class="text-2xl font-semibold mb-2">Keranjang kamu kosong 😢</h2>
    <a href="{{ route('home_page') }}" class="inline-block mt-4 bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
        Belanja Sekarang
    </a>
</div>
@else
<section class="py-10 px-4 md:px-14">
    <div class="overflow-x-auto rounded-xl shadow ring-1 ring-gray-200">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                <tr>
                    <th class="py-3 px-4 text-center">
                        <i class="fa-regular fa-circle-check"></i>
                    </th>
                    <th class="py-3 px-4 text-left">Produk</th>
                    <th class="py-3 px-4 text-right">Harga</th>
                    <th class="py-3 px-4 text-center">Jumlah</th>
                    <th class="py-3 px-4 text-right">Subtotal</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @foreach($cart as $item)
                @php
                    $product = $item->product;
                    $stock = optional($product->stock)->stock ?? 0;
                    $isOutOfStock = $stock === 0;
                    $isLimited = $stock <= $item->quantity;
                @endphp
                <tr class="{{ $isOutOfStock ? 'opacity-50' : '' }}">
                    <td class="py-4 px-4 text-center">
                        <input type="checkbox" 
                               class="item-checkbox" 
                               value="{{ $item->code_cart }}" 
                               data-subtotal="{{ $item->subtotal }}"
                               {{ $isOutOfStock ? 'disabled class=cursor-not-allowed' : '' }}>
                    </td>
                    <td class="py-4 px-4 flex items-center gap-4">
                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-14 h-14 rounded object-cover border" alt="">
                        <div>
                            <div class="font-medium text-gray-800">{{ $product->name }}</div>
                            @if ($isOutOfStock)
                                <p class="text-red-600 text-xs mt-1">Stok habis</p>
                            @elseif ($isLimited)
                                <p class="text-yellow-500 text-xs mt-1">Stok terbatas</p>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-4 text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="py-4 px-4 text-center">
                        @if ($isOutOfStock)
                        <input type="number" class="w-16 text-center border px-2 py-1 bg-gray-100 rounded" value="{{ $item->quantity }}" readonly>
                        @else
                        <input type="number" 
                               name="quantity" 
                               min="1" 
                               max="{{ $stock }}" 
                               value="{{ $item->quantity }}" 
                               data-code="{{ $product->code_product }}" 
                               class="w-16 text-center border px-2 py-1 rounded quantity-input">
                        @endif
                    </td>
                    <td class="py-4 px-4 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    <td class="py-4 px-4 text-center">
                        <form action="{{ route('cart.remove', ['code_product' => $product->code_product]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Total dan Checkout -->
    <div class="mt-8 flex justify-end">
        <div class="bg-white shadow-md border rounded-xl w-full max-w-md p-6">
            <h3 class="text-xl font-semibold mb-4">Ringkasan Keranjang</h3>
            <div class="flex justify-between text-gray-700 mb-4">
                <span>Total:</span>
                <span id="total-price" class="font-bold">Rp 0,00</span>
            </div>

            <form id="cart-form" action="{{ route('checkout.show') }}" method="GET">
                @csrf
                <div id="hidden-inputs"></div>
                <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition">
                    Checkout Sekarang
                </button>
            </form>
        </div>
    </div>
</section>
@endif


<!-- JS untuk menghitung total berdasarkan checkbox -->
<script>
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const totalPriceElement = document.getElementById('total-price');
    const hiddenInputsContainer = document.getElementById('hidden-inputs');
    const quantityInputs = document.querySelectorAll('.quantity-input');

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2
        }).format(angka);
    }

    function updateTotal() {
        let total = 0;
        hiddenInputsContainer.innerHTML = '';

        checkboxes.forEach(cb => {
            if (cb.checked) {
                total += parseFloat(cb.dataset.subtotal);

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'selected_items[]';
                hiddenInput.value = cb.value;
                hiddenInputsContainer.appendChild(hiddenInput);
            }
        });

        totalPriceElement.textContent = formatRupiah(total);
    }

    // Event: checkbox berubah
    checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
    document.addEventListener('DOMContentLoaded', updateTotal);

    // Event: quantity diubah
    quantityInputs.forEach(input => {
        input.addEventListener('change', () => {
            const newQuantity = parseInt(input.value) || 1;
            const code = input.dataset.code;

            fetch(`/cart/update/${code}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = input.closest('tr');
                    const subtotalCell = row.querySelector('td:nth-child(5)');
                    subtotalCell.textContent = formatRupiah(data.new_subtotal);

                    const checkbox = row.querySelector('.item-checkbox');
                    if (checkbox) {
                        checkbox.dataset.subtotal = data.new_subtotal;
                    }

                    updateTotal();
                } else {
                    alert(data.message || 'Gagal update kuantitas');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat update kuantitas');
            });
        });
    });
</script>

@endsection
