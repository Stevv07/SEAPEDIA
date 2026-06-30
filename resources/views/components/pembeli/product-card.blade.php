<!-- Tailwind Utility for line-clamp-2 -->
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<a href="{{ route('product.show', $product->code_product) }}" 
   class="group block bg-white rounded-xl border border-gray-200 hover:border-gray-300 hover:shadow-lg transition-all duration-200 overflow-hidden">

    <div class="p-4">
        <div class="bg-gray-50 rounded-lg p-4 group-hover:bg-gray-100 transition-colors duration-200">
            @if ($product->image)
                <img src="{{ asset('storage/'. $product->image) }}" alt="{{ $product->name }}"
                     class="w-full h-32 object-contain mx-auto group-hover:scale-105 transition-transform duration-200" />
            @else
                <div class="w-full h-32 flex items-center justify-center bg-gray-100 text-gray-400 text-sm rounded-lg border-2 border-dashed border-gray-300">
                    <div class="text-center">
                        <i class='bx bx-image text-2xl mb-2'></i>
                        <div class="font-medium">No Image</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="px-4 pb-4">
        <div class="text-center space-y-3">
            <h4 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                {{ $product->name }}
            </h4>

            <p class="text-xl font-bold text-gray-900">
                Rp {{ number_format($product->price, 2, ',', '.') }}</p>

            @php
                $stockCount = optional($product->stock)->stock ?? 0;
                $userEmail = Auth::check() ? Auth::user()->email : null;
                $cartQty = $userEmail ? \App\Models\Cart::where('user_email', $userEmail)
                            ->where('code_product', $product->code_product)
                            ->sum('quantity') : 0;
            @endphp

            <div class="flex items-center justify-center gap-2 text-sm">
                <span class="text-gray-600 font-medium">Stock:</span>
                @if($stockCount > 10)
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-700 font-semibold">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        {{ $stockCount }}
                    </span>
                @elseif($stockCount > 0)
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-orange-100 text-orange-700 font-semibold">
                        <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                        {{ $stockCount }}
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-red-100 text-red-700 font-semibold">
                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                        Out of Stock
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Add to Cart Button -->
    <div class="px-4 pb-4">
        @if ($stockCount <= 0)
            <div class="w-full bg-gray-400 text-white py-3 rounded-lg text-sm text-center cursor-not-allowed font-semibold">
                <span class="flex items-center justify-center gap-2">
                    <i class='bx bx-x-circle'></i>
                    Out of Stock
                </span>
            </div>
        @elseif ($cartQty >= $stockCount)
            <div class="w-full bg-yellow-500 text-white py-3 rounded-lg text-sm text-center cursor-not-allowed font-semibold">
                <span class="flex items-center justify-center gap-2">
                    <i class='bx bx-error'></i>
                    Maximum quantity reached
                </span>
            </div>
        @else
            <button onclick="event.stopPropagation(); event.preventDefault(); addToCart('{{ $product->code_product }}')"
                    class="add-to-cart-btn w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2 hover:shadow-md transform hover:-translate-y-0.5">
                <i class='bx bx-cart'></i> 
                Add to Cart
            </button>
        @endif
    </div>
</a>

<script>
    function addToCart(code_product) {
        const button = event.target.closest('button');
        const originalContent = button.innerHTML;

        button.innerHTML = `
            <span class="flex items-center justify-center gap-2">
                <div class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                Adding...
            </span>
        `;
        button.disabled = true;

        fetch(`/cart/add/${code_product}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ quantity: 1 })
        })
        .then(response => {
            if(response.status === 401) {
                window.location.href = "{{ route('login') }}";
                return;
            }
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Failed to add to cart');
                });
            }
            return response.json();
        })
        .then(data => {
            if (!data) return;

            button.innerHTML = `
                <span class="flex items-center justify-center gap-2">
                    <i class='bx bx-check'></i>
                    Added!
                </span>
            `;
            button.className = 'w-full bg-green-600 text-white py-3 rounded-lg text-sm font-semibold';

            showNotification(data.message || 'Added to cart!', 'success');
            if (data.cartCount !== undefined) {
                updateCartCount(data.cartCount);
            }

            setTimeout(() => {
                button.innerHTML = originalContent;
                button.disabled = false;
                button.className = 'add-to-cart-btn w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2 hover:shadow-md transform hover:-translate-y-0.5';
            }, 2000);
        })
        .catch(error => {
            button.innerHTML = `
                <span class="flex items-center justify-center gap-2">
                    <i class='bx bx-x'></i>
                    Error!
                </span>
            `;
            button.className = 'w-full bg-red-600 text-white py-3 rounded-lg text-sm font-semibold';
            showNotification(error.message || 'Error adding to cart', 'error');

            setTimeout(() => {
                button.innerHTML = originalContent;
                button.disabled = false;
                button.className = 'add-to-cart-btn w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2 hover:shadow-md transform hover:-translate-y-0.5';
            }, 2000);
        });
    }

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        notification.className = `fixed top-4 right-4 ${bgColor} text-white px-4 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
        notification.innerHTML = `
            <div class="flex items-center gap-2">
                <i class='bx ${type === 'success' ? 'bx-check' : 'bx-x'}'></i>
                <span class="text-sm font-medium">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="text-white/80 hover:text-white ml-2">
                    <i class='bx bx-x text-sm'></i>
                </button>
            </div>
        `;
        document.body.appendChild(notification);
        setTimeout(() => notification.classList.remove('translate-x-full'), 100);
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 3500);
    }

    function updateCartCount(newCount) {
        const cartSpan = document.querySelector("#cart-count");
        if (cartSpan) {
            cartSpan.textContent = newCount;
            if (newCount > 0) {
                cartSpan.classList.remove('hidden');
            }
        }
    }
</script>