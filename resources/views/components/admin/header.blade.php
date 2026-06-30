<header class="bg-[#b0cee3] shadow sticky top-0 z-10">
  <div class="flex items-center justify-between px-4 py-3">
    <!-- Kiri: Sidebar toggle & search -->
    <div class="flex items-center">
      <!-- Button Toggle Sidebar (untuk Mobile) -->
      <button id="toggle-sidebar" class="text-gray-700 focus:outline-none md:hidden">
        <i class="fas fa-bars text-xl"></i>
      </button>

      <!-- Search Input (Desktop) -->
      <div class="relative ml-4 hidden sm:block">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
          <i class="fas fa-search text-gray-500"></i>
        </span>
        <input class="w-full sm:w-64 rounded-full pl-10 pr-4 py-2 focus:outline-none focus:shadow-outline bg-white" type="text" placeholder="Search">
      </div>
    </div>

    <!--  Notifikasi dan  Profile -->
    <div class="flex items-center space-x-4 md:space-x-6">
      <div class="relative" x-data="{ openNotif: false }" @click.away="openNotif = false">
        <button @click="openNotif = !openNotif" class="relative">
          <i class="fas fa-bell text-xl"></i>
          <span class="absolute top-0 right-0 h-5 w-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs">
            {{ count($waitingOrders) }}
          </span>
        </button>

        <!-- Notifikasi Dropdown -->
      <div 
        x-show="openNotif"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-xl border border-gray-200 max-h-[420px] overflow-y-auto z-50"
        style="display: none;"
      >
        <!-- Header -->
        <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white rounded-t-xl">
          <h2 class="text-sm font-semibold text-gray-700 tracking-wide uppercase">
            New Order Notifications
          </h2>
        </div>

        <!-- Isi Notifikasi -->
        @forelse ($waitingOrders->take(6) as $order)
        <a href="{{ route('notif.index') }}" class="block hover:bg-gray-50 transition">
          <div class="flex items-center gap-4 px-5 py-4 border-b border-gray-100">
            <!-- Logo Metode Pembayaran -->
            <div class="w-10 h-10 rounded-full overflow-hidden border shadow-sm bg-white flex items-center justify-center">
              <img src="{{ asset($order->payment->logo_path) }}" 
                  alt="{{ $order->payment->method_name }}" 
                  class="object-contain h-6 w-6">
            </div>

            
            <!-- Detail -->
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-center mb-0.5">
                <p class="text-sm font-medium text-gray-800 truncate">{{ $order->user->name }}</p>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                  {{ $order->status === 'pending_payment' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                  {{ $order->status === 'pending_payment' ? 'Unpaid' : 'Paid' }}
                </span>
              </div>
              <p class="text-xs text-gray-500 truncate">
                Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
              </p>
            </div>
          </div>
        </a>
        @empty
        <div class="p-5 text-center text-sm text-gray-500">
          No new notifications.
        </div>
        @endforelse

        <!-- Footer -->
        <div class="px-5 py-3 bg-gray-50 border-t border-gray-200 rounded-b-xl text-center">
          <a href="{{ route('notif.index') }}" class="text-sm font-medium text-indigo-600 hover:underline">
            View All Notifications
          </a>
        </div>
      </div>
      </div>

  <!-- Mobile Search -->
  <div class="px-4 pb-3 sm:hidden">
    <div class="relative">
      <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
        <i class="fas fa-search text-gray-500"></i>
      </span>
      <input class="w-full rounded-full pl-10 pr-4 py-2 focus:outline-none focus:shadow-outline bg-white" type="text" placeholder="Search">
    </div>
  </div>
</header>

<script>
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');

    // Toggle dropdown saat tombol diklik
    userMenuButton.addEventListener('click', (event) => {
        event.stopPropagation(); // ⛔ Hentikan bubbling ke window
        userDropdown.classList.toggle('hidden');
    });

    // Tutup dropdown saat klik di luar
    window.addEventListener('click', (event) => {
        if (!userDropdown.contains(event.target)) {
            userDropdown.classList.add('hidden');
        }
    });
</script>

