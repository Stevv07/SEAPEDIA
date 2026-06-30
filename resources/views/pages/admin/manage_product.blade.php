@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Product Management Dashboard
                    </h1>
                    <p class="text-slate-600 mt-1">Manage your products, categories, brands, and stock in one place</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button onclick="showAddProductForm()" class="group relative bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-plus mr-2"></i>Add Product
                    </button>
                    <button onclick="showAddCategoryForm()" class="group relative bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-tag mr-2"></i>Add Category
                    </button>
                    <button onclick="showAddMerkForm()" class="group relative bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-star mr-2"></i>Add Brand
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if (session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl shadow-md">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-3"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Tab Navigation -->
    <div class="mb-6">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-2">
            <nav class="flex space-x-2" id="tabNavigation">
                <button onclick="switchTab('products')" class="tab-btn active flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    <i class="fas fa-box mr-2"></i>Products
                </button>
                <button onclick="switchTab('categories')" class="tab-btn flex-1 bg-transparent hover:bg-slate-100 text-slate-600 hover:text-slate-800 px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    <i class="fas fa-tags mr-2"></i>Categories
                </button>
                <button onclick="switchTab('merks')" class="tab-btn flex-1 bg-transparent hover:bg-slate-100 text-slate-600 hover:text-slate-800 px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    <i class="fas fa-crown mr-2"></i>Brands
                </button>
                <button onclick="switchTab('stock')" class="tab-btn flex-1 bg-transparent hover:bg-slate-100 text-slate-600 hover:text-slate-800 px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    <i class="fas fa-warehouse mr-2"></i>Stock
                </button>
            </nav>
        </div>
    </div>
    @include('components.admin.product')
    @include('components.admin.category')
    @include('components.admin.brands')
    @include('components.admin.stock')

<script>
    // Tab switching functionality
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-gradient-to-r', 'from-blue-500', 'to-blue-600', 'text-white');
            btn.classList.add('bg-transparent', 'hover:bg-slate-100', 'text-slate-600', 'hover:text-slate-800');
        });
        
        // Show selected tab content
        document.getElementById(tabName + '-tab').classList.remove('hidden');
        
        // Add active class to clicked tab button
        event.target.classList.remove('bg-transparent', 'hover:bg-slate-100', 'text-slate-600', 'hover:text-slate-800');
        event.target.classList.add('active', 'bg-gradient-to-r', 'from-blue-500', 'to-blue-600', 'text-white');
    }

    // Product functions
    function showEditForm(product) {
        const form = document.getElementById('editForm');
        const f = form.querySelector('form');

        f.action = `/admin/manage_product/${product.code_product}`;
        f.querySelector('input[name="code_product_original"]').value = product.code_product;
        f.querySelector('input[name="code_product"]').value = product.code_product;
        f.querySelector('input[name="name"]').value = product.name;
        f.querySelector('select[name="category"]').value = product.category?.code ?? '';
        f.querySelector('select[name="merk"]').value = product.merk?.code ?? '';
        f.querySelector('textarea[name="description"]').value = product.description ?? '';
        f.querySelector('input[name="price"]').value = product.price;
        f.querySelector('input[name="warranty"]').value = product.warranty ?? '';

        form.classList.remove('hidden');
    }

    function hideEditForm() {
        document.getElementById('editForm').classList.add('hidden');
    }

    function showAddProductForm() {
        document.getElementById('addProductForm').classList.remove('hidden');
    }

    function hideAddProductForm() {
        document.getElementById('addProductForm').classList.add('hidden');
    }

    // Category functions
    function showAddCategoryForm() {
        document.getElementById('addCategoryForm').classList.remove('hidden');
    }

 

    // Brand functions
    function showAddMerkForm() {
        document.getElementById('addMerkForm').classList.remove('hidden');
    }


    
    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        const modals = ['editForm', 'addProductForm', 'addCategoryForm', 'editCategoryForm', 'addMerkForm', 'editMerkForm', 'stockForm'];
        
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>

@endsection