@extends('layouts.app')

@section('content')
<nav class="text-sm text-gray-600 px-4 md:px-14 mt-4 py-2">
    <a href="{{ route('home_page') }}" class="hover:underline text-blue-600">Home</a> /
    <a href="{{ route('cart') }}" class="hover:underline text-blue-600">Cart</a> /
    <span class="text-gray-800 font-medium">Payment</span>
</nav>

<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6">
  <div class="text-center mb-8">
    <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-br from-indigo-500 to-blue-600 bg-clip-text text-transparent mb-2">
      Select Payment Method
    </h1>
    <p class="text-gray-600 text-sm sm:text-base">Choose a payment option to complete your purchase</p>
  </div>

  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Category Tabs -->
    <div class="flex justify-center bg-gray-50 p-6">
      <div class="flex flex-wrap justify-center bg-white rounded-full p-1 shadow-inner gap-2">
        <button onclick="showCategory('bank')" id="bank-tab"
          class="category-tab px-6 sm:px-8 py-3 rounded-full font-semibold transition-all duration-300 bg-gradient-to-r from-blue-500 to-blue-700 text-white shadow-md -translate-y-px">
          <i class='bx bx-building mr-2'></i>Bank Transfer
        </button>
        <button onclick="showCategory('e-wallet')" id="e-wallet-tab"
          class="category-tab px-6 sm:px-12 py-3 rounded-full font-semibold transition-all duration-300 text-white bg-gradient-to-r from-gray-500 to-gray-700 shadow-md -translate-y-px">
          <i class='bx bx-wallet mr-2'></i>E-Wallet
        </button>
      </div>
    </div>

    <!-- Payment Methods -->
    <div class="p-4 sm:p-6">
      <div id="payment-methods" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        @foreach($paymentMethods as $payment)
          <div class="payment-card cursor-pointer flex items-center bg-white border-2 p-4 sm:p-6 rounded-xl"
            data-category="{{ strtolower($payment->category) }}"
            onclick="selectMethod({{ json_encode($payment) }})">
            <div class="w-12 sm:w-14 h-12 sm:h-14 bg-gray-50 rounded-lg flex items-center justify-center mr-4">
              <img src="{{ asset($payment->logo_path) }}" class="w-8 sm:w-10 h-8 sm:h-10 object-contain" alt="{{ $payment->method_name }}" />
            </div>
            <div class="flex-grow">
              <span class="font-semibold text-base sm:text-lg">{{ $payment->method_name }}</span>
              <p class="text-gray-500 text-xs sm:text-sm">Pay directly via account</p>
            </div>
            <i class='bx bx-chevron-right text-gray-400 ml-auto text-lg sm:text-xl'></i>
          </div>
        @endforeach
      </div>

      <!-- Payment Detail Form -->
      <div id="payment-detail" class="hidden">
        <div class="border-t border-gray-200 pt-8">
          <h2 class="text-xl sm:text-2xl font-bold mb-6 flex items-center gap-3">
            <i class='bx bx-credit-card text-blue-600'></i> Payment Details
          </h2>
        </div>

        <form action="{{ route('payment.upload_proof') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
          @csrf
          <input type="hidden" name="payment_id" id="selectedPaymentId">
          <input type="hidden" name="order_code" value="{{ $order->order_code }}">

          <!-- Info Rekening -->
          <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6 border border-blue-100">
            <div class="flex items-center space-x-4 mb-4">
              <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-md">
                <img id="payment-logo" src="" class="w-10 h-10 object-contain" />
              </div>
              <div>
                <p id="method-name" class="text-base sm:text-lg font-semibold text-gray-800"></p>
                <p class="text-gray-600 text-sm">a.n <span id="account-name" class="font-semibold"></span></p>
              </div>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-2">
              <p class="text-sm text-gray-700">Account Number / Phone:</p>
              <div class="flex items-center gap-2">
                <p id="account-number" class="font-semibold text-gray-800 text-sm"></p>
                <button type="button" onclick="copyToClipboard(event)" class="text-sm text-blue-600 hover:underline">
                  <i class='bx bx-copy'></i> Copy
                </button>
              </div>
            </div>
          </div>

          <!-- Total Harga -->
          <div class="flex flex-wrap justify-between items-center mb-4">
            <span class="text-gray-700 font-medium text-sm sm:text-base">Total Payment:</span>
            <span class="text-xl sm:text-2xl font-bold text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
          </div>

          <!-- Deadline -->
          <div class="rounded-lg p-3 text-center bg-gradient-to-r from-amber-400 to-yellow-600 text-white animate-pulse mb-6 text-sm sm:text-base">
            <p class="font-semibold flex items-center justify-center gap-2">
              <i class='bx bx-time'></i>
              Transfer deadline:
              <span class="font-mono">{{ $order->expired_at->translatedFormat('l, d M Y H:i') }}</span>
            </p>
          </div>

          <!-- Upload Bukti -->
          <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 sm:p-8 text-center hover:border-blue-500 transition-colors mb-6">
            <i class='bx bx-cloud-upload text-4xl text-gray-400 mb-4'></i>
            <input type="file" name="payment_proof" required
              class="block w-full max-w-full text-sm text-gray-700 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
            <p class="text-gray-500 text-xs sm:text-sm mt-2">Format: JPG, PNG, PDF (Max: 5MB)</p>
          </div>

          <!-- Tombol Submit -->
          <button type="submit"
            class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-[1.02] flex items-center justify-center gap-3 text-sm sm:text-base">
            <i class='bx bx-send'></i>
            Upload Payment Proof
          </button>
        </form>
      </div>

      <!-- Warning -->
      <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6 mt-10 text-sm sm:text-base">
        <div class="flex items-start gap-3">
          <i class='bx bx-error text-red-500 text-xl mt-1'></i>
          <div>
            <h4 class="font-bold text-red-800 mb-2">Warning!</h4>
            <p class="text-red-700 mb-3">
              Please make sure the transfer amount is accurate. Incorrect payments are non-refundable.
            </p>
            <p class="text-red-700">
              Need help?
              <a href="{{ route('chat.index') }}" class="inline-flex items-center gap-1 underline font-semibold hover:text-red-600 transition-colors">
                <i class='bx bx-message-dots'></i> contact the seller
              </a>
            </p>
          </div>
        </div>
      </div>

      <!-- Popup Sukses -->
      <div id="successPopup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-8 shadow-xl text-center max-w-md w-full">
          <i class='bx bx-check-circle text-green-500 text-6xl mb-4'></i>
          <h2 class="text-2xl font-bold mb-2">Payment Successful!</h2>
          <p class="text-gray-600 mb-6">Awaiting confirmation from the seller.</p>
          <button onclick="redirectToInvoice()" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all">
            Oke
          </button>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  function showCategory(category) {
    document.querySelectorAll('.category-tab').forEach(tab => tab.classList.remove('tab-active'));
    document.getElementById(category + '-tab').classList.add('tab-active');

    const cards = document.querySelectorAll('.payment-card');
    cards.forEach(card => {
      const cardCategory = card.getAttribute('data-category');
      card.style.display = (cardCategory === category) ? 'flex' : 'none';
    });

    document.getElementById('payment-detail').classList.add('hidden');
  }

  function selectMethod(payment) {
    document.getElementById('payment-logo').src = '/' + payment.logo_path;
    document.getElementById('method-name').textContent = payment.method_name;
    document.getElementById('account-name').textContent = payment.account_name;
    document.getElementById('account-number').textContent = payment.account_number;
    document.getElementById('selectedPaymentId').value = payment.id;
    document.getElementById('payment-detail').classList.remove('hidden');
    document.getElementById('payment-detail').scrollIntoView({ behavior: 'smooth' });
  }

  function copyToClipboard(event) {
    const text = document.getElementById('account-number').textContent;
    navigator.clipboard.writeText(text).then(() => {
      const button = event.currentTarget;
      const originalText = button.innerHTML;
      button.innerHTML = '<i class="bx bx-check"></i> Disalin!';
      button.classList.add('bg-green-500', 'text-white');
      setTimeout(() => {
        button.innerHTML = originalText;
        button.classList.remove('bg-green-500', 'text-white');
      }, 2000);
    });
  }

  function redirectToInvoice() {
    const invoiceUrl = "{{ route('invoice.show', $order->order_code) }}";
    window.location.href = invoiceUrl;
  }

  window.addEventListener('load', () => {
    showCategory('bank');
  });

  // Expose ke global jika pakai onclick di HTML
  window.selectMethod = selectMethod;
  window.copyToClipboard = copyToClipboard;
  window.showCategory = showCategory;
</script>

@endsection
