<!-- Stock Tab -->
<div id="stock-tab" class="tab-content hidden">
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-100 to-indigo-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Product Code</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Product Name</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Current Stock</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm font-mono text-slate-600">{{ $product->code_product }}</td>
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $product->name }}</td>
                            <td class="px-6 py-4">
                                <span class="text-2xl font-bold text-slate-900">{{ $product->stock->stock ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $stock = $product->stock->stock ?? 0;
                                    $statusClass = $stock > 10 ? 'bg-green-100 text-green-800' : ($stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800');
                                    $statusText = $stock > 10 ? 'In Stock' : ($stock > 0 ? 'Low Stock' : 'Out of Stock');
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick='showStockForm(@json($product))' class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" title="Update Stock">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-500">
                                    <i class="fas fa-warehouse text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">No stock data available</p>
                                    <p class="text-sm">Products will appear here once added</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Stock Update Form -->
<div id="stockForm" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-start overflow-auto pt-10 z-50">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 my-8 shadow-2xl border border-white/20">
        <div class="p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Update Stock</h2>
                <button onclick="hideStockForm()" class="p-2 hover:bg-slate-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-times text-slate-400"></i>
                </button>
            </div>
            <form id="updateStockForm" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Product Code</label>
                    <input name="code_product" readonly class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-slate-100 cursor-not-allowed" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Product Name</label>
                    <input name="product_name" readonly class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-slate-100 cursor-not-allowed" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Current Stock</label>
                    <input name="current_stock" readonly class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-slate-100 cursor-not-allowed text-2xl font-bold text-center" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">New Stock Amount</label>
                    <input name="stock" required type="number" min="0" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-2xl font-bold text-center" />
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="hideStockForm()" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl font-medium transition-all duration-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl font-medium transition-all duration-300 shadow-lg">
                        Update Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showStockForm(product) {
        const formWrapper = document.getElementById('stockForm');
        const form = document.getElementById('updateStockForm');

        // Set form action sesuai product
        form.action = `/admin/stock/${product.code_product}`;

        // Isi form dengan data produk
        form.querySelector('input[name="code_product"]').value = product.code_product;
        form.querySelector('input[name="product_name"]').value = product.name;
        form.querySelector('input[name="current_stock"]').value = product.stock?.stock ?? 0;
        form.querySelector('input[name="stock"]').value = product.stock?.stock ?? 0;

        formWrapper.classList.remove('hidden');
    }

    function hideStockForm() {
        document.getElementById('stockForm').classList.add('hidden');
    }
</script>
