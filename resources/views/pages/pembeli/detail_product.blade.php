@extends('layouts.app')

@section('content')
<!-- Simple Breadcrumb -->
<nav class="px-6 lg:px-20 mt-6 py-3">
  <div class="flex items-center gap-2 text-sm text-gray-600">
    <a href="{{ route('home_page') }}" class="hover:text-blue-600 transition-colors">Home</a>
    <span>/</span>
    <a href="{{ route('products') }}" class="hover:text-blue-600 transition-colors">Products</a>
    <span>/</span>
    <span class="text-gray-900 font-medium">{{ $product->name }}</span>
  </div>
</nav>

<main class="my-12 px-4 sm:px-6 md:px-10 lg:px-20">
  @php
    $availableStock = optional($product->stock)->stock ?? 0;
    $userEmail = Auth::check() ? Auth::user()->email : null;
    $cartQty = $userEmail ? \App\Models\Cart::where('user_email', $userEmail)
                ->where('code_product', $product->code_product)
                ->sum('quantity') : 0;
    $remainingStock = max($availableStock - $cartQty, 0);
  @endphp

  <div class="grid lg:grid-cols-2 gap-12 max-w-7xl mx-auto">  
    <!-- Enhanced Image Section -->
    <div class="relative">
      <div class="group bg-gradient-to-br from-white to-gray-50/50 rounded-3xl border border-gray-200/60 p-8 shadow-lg hover:shadow-xl transition-all duration-500">
        @if ($product->image)
          <div class="relative overflow-hidden rounded-2xl">
            <img src="{{ asset('storage/'. $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-96 object-contain transition-all duration-700 group-hover:scale-110" />
            <!-- Modern Zoom Overlay -->
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-all duration-300 flex items-center justify-center">
              <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-75 group-hover:scale-100 shadow-lg">
                <i class='bx bx-search-alt-2 text-gray-700 text-lg'></i>
              </div>
            </div>
            <!-- Image Badge -->
            <div class="absolute top-4 left-4 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
              HD Quality
            </div>
          </div>
        @else
          <div class="w-full h-96 flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 text-gray-400 rounded-2xl border-2 border-dashed border-gray-300">
            <div class="text-center">
              <div class="w-20 h-20 mx-auto mb-4 bg-gray-200 rounded-full flex items-center justify-center">
                <i class='bx bx-image text-3xl'></i>
              </div>
              <div class="font-medium">No image available</div>
              <div class="text-sm mt-1">Product image coming soon</div>
            </div>
          </div>
        @endif
      </div>
    </div>

    <!-- Product Details - Kompak -->
    <div class="space-y-4">
      <!-- Product Header -->
      <div class="space-y-2">
        <h1 class="text-2xl font-bold text-gray-900 leading-tight">{{ $product->name }}</h1>
        
        <!-- Stock Status - Dipindah ke bawah nama produk -->
        <div class="flex items-center gap-2">
          @if($remainingStock > 10)
            <div class="flex items-center gap-2 bg-green-50 text-green-800 px-2 py-1 rounded-full border border-green-200">
              <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></div>
              <span class="font-semibold text-xs">In Stock</span>
              <span class="bg-green-200 text-green-800 px-1.5 py-0.5 rounded-full text-xs font-bold">{{ $availableStock }}</span>
            </div>
          @elseif($remainingStock > 0)
            <div class="flex items-center gap-2 bg-orange-50 text-orange-800 px-2 py-1 rounded-full border border-orange-200">
              <div class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></div>
              <span class="font-semibold text-xs">Limited Stock</span>
              <span class="bg-orange-200 text-orange-800 px-1.5 py-0.5 rounded-full text-xs font-bold">{{ $availableStock }}</span>
            </div>
          @else
            <div class="flex items-center gap-2 bg-red-50 text-red-800 px-2 py-1 rounded-full border border-red-200">
              <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
              <span class="font-semibold text-xs">Out of Stock</span>
            </div>
          @endif
        </div>
      </div>

      <!-- Price Section - Dipindah ke kanan -->
      <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-2.5 border border-blue-100">
        <div class="flex items-baseline justify-between">
          <div class="text-lg font-bold text-gray-900">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </div>
          <div class="bg-green-100 text-green-800 px-1.5 py-0.5 rounded-full text-xs font-semibold">
            Best Price
          </div>
        </div>
        <div class="flex items-center gap-2 mt-1.5 text-xs text-gray-600">
          <div class="flex items-center gap-1">
            <i class='bx bx-check-circle text-green-500 text-xs'></i>
            <span>Tax included</span>
          </div>
          <div class="flex items-center gap-1">
            <i class='bx bx-truck text-blue-500 text-xs'></i>
            <span>Free shipping</span>
          </div>
        </div>
      </div>

      <!-- Description & Specifications - Lebih kompak -->
      <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <div class="p-3">
          <h3 class="text-sm font-bold text-gray-900 mb-1.5">Product Details</h3>
          <p class="text-gray-700 leading-relaxed text-xs mb-2">
            {{ $product->description ?? 'This product comes with excellent quality and reliable performance. Perfect for your needs with great value for money.' }}
          </p>
          
          <div class="grid grid-cols-2 gap-1.5 pt-1.5 border-t border-gray-100">
            <div>
              <div class="text-xs font-medium text-gray-500">Category</div>
              <div class="font-medium text-gray-900 text-xs">{{ $product->category->name ?? 'General' }}</div>
            </div>
            <div>
              <div class="text-xs font-medium text-gray-500">Brand</div>
              <div class="font-medium text-gray-900 text-xs">{{ $product->merk->name ?? 'Unknown' }}</div>
            </div>
            <div>
              <div class="text-xs font-medium text-gray-500">Warranty</div>
              <div class="font-medium text-gray-900 text-xs">{{ $product->warranty ?? '1 Year' }}</div>
            </div>
            <div>
              <div class="text-xs font-medium text-gray-500">SKU</div>
              <div class="font-mono text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded text-xs">{{ $product->code_product }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Add to Cart Section - Lebih kompak -->
      @if ($remainingStock > 0)
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-2.5">
          <form action="{{ route('cart.add', ['code_product' => $product->code_product]) }}" method="POST" class="space-y-1.5">
            @csrf
            
            <!-- Quantity Selector -->
            <div class="flex items-center gap-2">
              <label class="text-xs font-semibold text-gray-900">Qty:</label>
              <div class="flex items-center bg-gray-50 rounded-full overflow-hidden border border-gray-200">
                <button type="button" class="sub w-6 h-6 flex items-center justify-center hover:bg-gray-200 transition-colors duration-200 focus:outline-none text-xs font-bold text-gray-600">−</button>
                <div class="value w-7 text-center py-0.5 font-bold text-gray-900 text-xs">1</div>
                <button type="button" class="add w-6 h-6 flex items-center justify-center hover:bg-gray-200 transition-colors duration-200 focus:outline-none text-xs font-bold text-gray-600">+</button>
              </div>
              <div class="bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded-full text-xs font-medium">
                Max {{ $availableStock }}
              </div>
            </div>
            
            <input type="hidden" name="quantity" id="quantity-input" value="1">
            
            <!-- Add to Cart Button -->
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-1.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center gap-1.5 shadow-md hover:shadow-lg text-xs">
              <i class='bx bx-cart-add text-sm'></i> 
              Add To Cart
            </button>
          </form>
        </div>
      @else
        <div class="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-lg p-2.5 text-center">
          <div class="w-6 h-6 mx-auto mb-1.5 bg-red-100 rounded-full flex items-center justify-center">
            <i class='bx bx-x-circle text-red-500 text-sm'></i>
          </div>
          <div class="text-red-900 font-bold mb-0.5 text-xs">Out of Stock</div>
          <div class="text-red-700 text-xs">This product is currently unavailable</div>
        </div>
      @endif

      <!-- Feature Cards - Lebih kompak -->
      <div class="grid grid-cols-2 gap-2">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-2 border border-blue-200">
          <div class="flex items-center gap-1.5">
            <div class="w-5 h-5 bg-blue-500 rounded-lg flex items-center justify-center">
              <i class='bx bx-truck text-white text-xs'></i>
            </div>
            <div>
              <div class="font-bold text-blue-900 text-xs">Free Delivery</div>
              <div class="text-blue-700 text-xs">2-3 days</div>
            </div>
          </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-2 border border-green-200">
          <div class="flex items-center gap-1.5">
            <div class="w-5 h-5 bg-green-500 rounded-lg flex items-center justify-center">
              <i class='bx bx-shield-check text-white text-xs'></i>
            </div>
            <div>
              <div class="font-bold text-green-900 text-xs">Warranty</div>
              <div class="text-green-700 text-xs">{{ $product->warranty ?? '1 Year' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

@if ($remainingStock > 0)
<div id="product-data" data-max-stock="{{ $remainingStock }}"></div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const sub = document.querySelector(".sub");
    const add = document.querySelector(".add");
    const value = document.querySelector(".value");
    const quantityInput = document.querySelector("#quantity-input");

    let totalQuantity = 1;
    const maxStock = parseInt(document.getElementById("product-data").dataset.maxStock);

    sub.addEventListener('click', function() {
      if (totalQuantity > 1) {
        totalQuantity--;
        value.textContent = totalQuantity;
        quantityInput.value = totalQuantity;
        
        // Re-enable add button if it was disabled
        add.disabled = false;
        add.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
        add.classList.add('hover:bg-gray-200');
      }
      
      // Add subtle animation
      value.style.transform = 'scale(1.2)';
      setTimeout(() => value.style.transform = 'scale(1)', 150);
    });

    add.addEventListener('click', function() {
      if (totalQuantity < maxStock) {
        totalQuantity++;
        value.textContent = totalQuantity;
        quantityInput.value = totalQuantity;
        
        // Add subtle animation
        value.style.transform = 'scale(1.2)';
        setTimeout(() => value.style.transform = 'scale(1)', 150);
      }
      
      if (totalQuantity >= maxStock) {
        add.disabled = true;
        add.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
        add.classList.remove('hover:bg-gray-200');
        
        showToast("Maximum quantity reached (" + maxStock + " items)", "warning");
      }
    });

    // Enhanced toast notification
    function showToast(message, type = 'info') {
      const toast = document.createElement('div');
      const bgColor = type === 'warning' ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'bg-gradient-to-r from-blue-500 to-blue-600';
      const icon = type === 'warning' ? 'bx-error-circle' : 'bx-info-circle';
      
      toast.className = `fixed top-6 right-6 ${bgColor} text-white px-6 py-4 rounded-2xl shadow-2xl z-50 transform translate-x-full transition-all duration-300 border border-white/20 backdrop-blur-sm`;
      toast.innerHTML = `
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
            <i class='bx ${icon} text-sm'></i>
          </div>
          <span class="font-medium">${message}</span>
          <button onclick="this.parentElement.parentElement.remove()" class="w-6 h-6 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-colors duration-200 ml-2">
            <i class='bx bx-x text-xs'></i>
          </button>
        </div>
      `;
      
      document.body.appendChild(toast);
      
      setTimeout(() => toast.classList.remove('translate-x-full'), 100);
      setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => toast.remove(), 300);
      }, 4000);
    }
  });
</script>
@endif

@endsection
