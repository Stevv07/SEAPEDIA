<!-- Products Tab -->
    <div id="products-tab" class="tab-content">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-slate-100 to-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Image</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Product Code</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Category</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Brand</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Description</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Price</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Warranty</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Stock</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-slate-50/50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    @if($product->image)
                                        <div class="relative w-16 h-16 rounded-xl overflow-hidden shadow-md">
                                            <img src="{{ asset('storage/'. $product->image) }}" alt="Product Image" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center">
                                            <i class="fas fa-image text-slate-400 text-xl"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-mono text-slate-600">{{ $product->code_product }}</td>
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $product->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        {{ $product->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ $product->merk->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate">{{ $product->description ?? '-' }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $product->warranty ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $product->stock->stock ?? 0 }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button onclick='showEditForm(@json($product))' class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('manage_product.destroy', $product->code_product) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete this product?')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-500">
                                        <i class="fas fa-box-open text-4xl mb-4"></i>
                                        <p class="text-lg font-medium">No products available</p>
                                        <p class="text-sm">Add your first product to get started</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Edit Product Form -->
<div id="editForm" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-start overflow-auto pt-10 z-50">
    <div class="bg-white rounded-2xl w-full max-w-2xl mx-4 my-8 shadow-2xl border border-white/20">
        <div class="p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Edit Product</h2>
                <button onclick="hideEditForm()" class="p-2 hover:bg-slate-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-times text-slate-400"></i>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="code_product_original" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Product Image</label>
                        <input type="file" name="image" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Product Code</label>
                        <input name="code_product" readonly class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-slate-100 cursor-not-allowed" />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Product Name</label>
                        <input name="name" required class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Category</label>
                        <select name="category" required class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->code }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Brand</label>
                        <select name="merk" required class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            <option value="">-- Select Brand --</option>
                            @foreach($merks as $merk)
                                <option value="{{ $merk->code }}">{{ $merk->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Price</label>
                        <input name="price" required type="number" step="0.01" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Warranty</label>
                        <input name="warranty" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="hideEditForm()" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl font-medium transition-all duration-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl font-medium transition-all duration-300 shadow-lg">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Product Form -->
<div id="addProductForm" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-start overflow-auto pt-10 z-50">
    <div class="bg-white rounded-2xl w-full max-w-2xl mx-4 my-8 shadow-2xl border border-white/20">
        <div class="p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Add New Product</h2>
                <button onclick="hideAddProductForm()" class="p-2 hover:bg-slate-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-times text-slate-400"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('manage_product.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Product Image</label>
                        <input type="file" name="image" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Product Code</label>
                        <input name="code_product" required value="{{ old('code_product') }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Product Name</label>
                        <input name="name" required value="{{ old('name') }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Category</label>
                        <select name="category" required class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->code }}" {{ old('category') == $category->code ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Brand</label>
                        <select name="merk" required class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            <option value="">-- Select Brand --</option>
                            @foreach($merks as $merk)
                                <option value="{{ $merk->code }}" {{ old('merk') == $merk->code ? 'selected' : '' }}>{{ $merk->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Price</label>
                        <input name="price" required type="number" step="0.01" value="{{ old('price') }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Warranty</label>
                        <input name="warranty" value="{{ old('warranty') }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="hideAddProductForm()" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl font-medium transition-all duration-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl font-medium transition-all duration-300 shadow-lg">
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>