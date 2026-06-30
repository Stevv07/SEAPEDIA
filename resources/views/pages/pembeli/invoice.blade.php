<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Invoice</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen px-4 md:px-8 py-6">
  <div id="invoice" class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
    <!-- Header -->
    <div class="relative bg-blue-400 px-6 py-4">
      <div class="flex justify-between items-center">
        <div class="flex items-center space-x-2">
          <div class="w-8 h-8 bg-white/30 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
          <div>
            <h1 class="text-lg font-bold text-white">E-TechnoCart</h1>
          </div>
        </div>
        <div class="text-right">
          <div class="bg-white/30 rounded-lg px-4 py-2 border border-white/40">
            <span class="text-white font-bold text-sm">INVOICE</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Order Details -->
    <div class="px-6 py-6">
      <div class="flex items-center space-x-2 mb-4">
        <div class="w-6 h-6 bg-blue-400 rounded-md flex items-center justify-center">
          <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
        </div>
        <h2 class="text-lg font-bold text-gray-800">Order Details</h2>
      </div>
      <div class="grid md:grid-cols-2 gap-4">
        <!-- Order Info Card -->
        <div class="bg-blue-100 rounded-lg p-4 border border-blue-200">
          <h3 class="font-semibold text-gray-700 mb-3 flex items-center text-sm">
            <svg class="w-4 h-4 mr-2 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Order Information
          </h3>
          <div class="space-y-2 text-xs">
            <div class="flex justify-between items-center p-2 bg-white/70 rounded-md">
              <span class="text-gray-600">Order ID</span>
              <span class="font-semibold text-gray-800">{{ $order->order_code }}</span>
            </div>
            <div class="flex justify-between items-center p-2 bg-white/70 rounded-md">
              <span class="text-gray-600">Order Date</span>
              <span class="font-semibold text-gray-800">{{ $order->created_at->format('d M Y', 'H:i') }}</span>
            </div>
            <div class="flex justify-between items-center p-2 bg-white/70 rounded-md">
              <span class="text-gray-600">Payment Method</span>
              <span class="font-semibold text-gray-800">{{ $order->payment->method_name }}</span>
            </div>
            <div class="flex justify-between items-center p-2 bg-white/70 rounded-md">
              <span class="text-gray-600">Status</span>
              <span class="font-semibold">
                @switch($order->status)
                  @case('pending')
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Pending</span>
                    @break
                  @case('processing')
                    <span class="px-2 py-1 bg-blue-200 text-blue-800 rounded-full text-xs font-medium">Processing</span>
                    @break
                  @case('completed')
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Completed</span>
                    @break
                  @case('cancelled')
                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Cancelled</span>
                    @break
                  @default
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">{{ ucfirst($order->status) }}</span>
                @endswitch
              </span>
            </div>
          </div>
        </div>

        <!-- Customer Info Card -->
        <div class="bg-blue-100 rounded-lg p-4 border border-blue-200">
          <h3 class="font-semibold text-gray-700 mb-3 flex items-center text-sm">
            <svg class="w-4 h-4 mr-2 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Customer Information
          </h3>
          <div class="space-y-2 text-xs">
            <div class="p-2 bg-white/70 rounded-md">
              <span class="text-gray-600 block">Name</span>
              <span class="font-semibold text-gray-800">{{ $order->user->name }}</span>
            </div>
            <div class="p-2 bg-white/70 rounded-md">
              <span class="text-gray-600 block">Address</span>
              <span class="font-semibold text-gray-800">{{ $order->user->address }}</span>
            </div>
            <div class="p-2 bg-white/70 rounded-md">
              <span class="text-gray-600 block">Phone</span>
              <span class="font-semibold text-gray-800">{{ $order->user->phone }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="px-6 pb-4">
      <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
        <div class="flex items-center space-x-2 mb-3">
          <div class="w-6 h-6 bg-blue-400 rounded-md flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
          </div>
          <h3 class="text-base font-bold text-gray-800">Order Items</h3>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="bg-blue-100">
                <th class="text-left px-4 py-3 font-semibold text-gray-700 rounded-l-md text-sm">Product</th>
                <th class="text-center px-4 py-3 font-semibold text-gray-700 text-sm">Quantity</th>
                <th class="text-center px-4 py-3 font-semibold text-gray-700 text-sm">Price</th>
                <th class="text-right px-4 py-3 font-semibold text-gray-700 rounded-r-md text-sm">Total</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @foreach ($invoiceProducts as $item)
                <tr class="hover:bg-white/50 transition-colors duration-200">
                  <td class="px-4 py-3">
                    <div class="flex items-center space-x-3">
                      <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $item->product->image ?? 'placeholder.png') }}" 
                            alt="{{ $item->product->product_name }}"
                            class="w-10 h-10 object-cover rounded-lg shadow-sm border border-gray-200" />
                      </div>
                      <div>
                        <div class="font-semibold text-gray-800 text-sm">{{ $item->product->name }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-3 text-center">
                    <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-800 rounded-full font-semibold text-xs">
                      {{ $item->quantity }}
                    </span>
                  </td>
                  <td class="px-4 py-3 text-center font-medium text-gray-700 text-sm">
                    Rp{{ number_format($item->order_price, 0, ',', '.') }}
                  </td>
                  <td class="px-4 py-3 text-right font-bold text-gray-800 text-sm">
                    Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Total Section -->
    <div class="px-6 pb-4">
      <div class="flex justify-end">
        <div class="bg-blue-400 rounded-lg p-4 text-white min-w-[250px]">
          <div class="flex justify-between items-center">
            <span class="text-sm font-medium">Sub Total</span>
            <span class="text-lg font-bold">Rp{{ number_format($subTotal, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="px-6 pb-6">
      <div class="flex flex-wrap justify-end gap-3">
        <button onclick="downloadAsImage()" 
                class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
          <div class="flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Download PNG</span>
          </div>
        </button>

        <button onclick="downloadAsPDF()" 
                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
          <div class="flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Download PDF</span>
          </div>
        </button>

        <a href="{{ route('order.list') }}">
          <button class="px-6 py-2 bg-blue-400 hover:bg-blue-600 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
            <div class="flex items-center space-x-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span>Done</span>
            </div>
          </button>
        </a>
      </div>
    </div>
  </div>

  <script>
    function downloadAsImage() {
      const invoice = document.getElementById('invoice');
      html2canvas(invoice, {
        scale: 2,
        useCORS: true,
        backgroundColor: '#ffffff'
      }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'invoice.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
      });
    }

    async function downloadAsPDF() {
      const invoice = document.getElementById('invoice');
      const canvas = await html2canvas(invoice, {
        scale: 2,
        useCORS: true,
        backgroundColor: '#ffffff'
      });
      const imgData = canvas.toDataURL('image/png');
      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF('p', 'pt', 'a4');
      const pdfWidth = pdf.internal.pageSize.getWidth();
      const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
      pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
      pdf.save('invoice.pdf');
    }
  </script>
</body>
</html>
