<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Merk;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'merk', 'stock'])->get();
        $categories = Category::all();
        $merks = Merk::all();

        return view('pages.admin.manage_product', compact('products', 'categories', 'merks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code_product' => 'required|string|max:255|unique:products,code_product',
            'name' => 'required|string|max:255',
            'category' => ['required', 'exists:categories,code'],
            'merk' => ['required', 'exists:merks,code'],
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'warranty' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        DB::transaction(function () use ($data) {
            Product::create([
                'code_product' => $data['code_product'],
                'name' => $data['name'],
                'category_code' => $data['category'],
                'merk_code' => $data['merk'],
                'description' => $data['description'] ?? null,
                'price' => $data['price'],
                'warranty' => $data['warranty'] ?? null,
                'image' => $data['image'] ?? null,
            ]);

            Stock::create(['code_product' => $data['code_product'], 'quantity' => 0]);
        });

        return redirect()->route('manage_product.index')->with('success', 'Product added with initial stock 0!');
    }

    public function update(Request $request, $code_product)
    {
        $product = Product::findOrFail($code_product);

        $data = $request->validate([
            'code_product' => "required|string|max:255|unique:products,code_product,{$code_product},code_product",
            'name' => 'required|string|max:255',
            'category' => ['required', 'exists:categories,code'],
            'merk' => ['required', 'exists:merks,code'],
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'warranty' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = 'storage/' . $request->file('image')->store('uploads', 'public');
        }

        DB::transaction(function () use ($product, $data) {
            $oldCode = $product->code_product;

            $product->update([
                'code_product' => $data['code_product'],
                'name' => $data['name'],
                'category_code' => $data['category'],
                'merk_code' => $data['merk'],
                'description' => $data['description'] ?? null,
                'price' => $data['price'],
                'warranty' => $data['warranty'] ?? null,
                'image' => $data['image'] ?? $product->image,
            ]);

            if ($oldCode !== $data['code_product']) {
                Stock::where('code_product', $oldCode)->update(['code_product' => $data['code_product']]);
            }
        });

        return redirect()->route('manage_product.index')->with('success', 'Product updated!');
    }

    public function destroy($code_product)
    {
        $product = Product::withCount('orderItems')->findOrFail($code_product);

        if ($product->order_items_count > 0) {
            return redirect()->route('manage_product.index')->with('error', 'Tidak bisa menghapus produk karena ada transaksi.');
        }

        DB::transaction(function () use ($product) {
            Stock::where('code_product', $product->code_product)->delete();
            $product->delete();
        });

        return redirect()->route('manage_product.index')->with('success', 'Product and stock deleted!');
    }

    public function updateStock(Request $request, $code_product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $stock = Stock::where('code_product', $code_product)->firstOrFail();
        $stock->stock = $request->stock;
        $stock->save();

        return redirect()->route('manage_product.index')->with('success', 'Stock updated successfully!');
    }

    public function storeMerk(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:merks,code',
            'name' => 'required|string|max:255',
        ]);

        Merk::create([
            'code' => $data['code'],
            'name' => $data['name'],
        ]);

        return redirect()->route('manage_product.index')->with('success', 'Brand added successfully!');
    }

    public function updateMerk(Request $request, $code)
    {
        $merk = Merk::findOrFail($code);

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $merk->update([
            'name' => $data['name'],
        ]);

        return redirect()->route('manage_product.index')->with('success', 'Brand updated successfully!');
    }

    public function destroyMerk($code)
    {
        $merk = Merk::withCount('products')->findOrFail($code);

        if ($merk->products_count > 0) {
            return redirect()->route('manage_product.index')->with('error', 'Tidak bisa menghapus Brand karena masih ada produk.');
        }

        $merk->delete();

        return redirect()->route('manage_product.index')->with('success', 'Brand deleted successfully!');
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:categories,code',
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'code' => $data['code'],
            'name' => $data['name'],
        ]);

        return redirect()->route('manage_product.index')->with('success', 'Category added!');
    }

    public function updateCategory(Request $request, $code)
    {
        $category = Category::findOrFail($code);

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $data['name'],
        ]);

        return redirect()->route('manage_product.index')->with('success', 'Category updated!');
    }

    public function destroyCategory($code)
    {
        $category = Category::withCount('products')->findOrFail($code);

        if ($category->products_count > 0) {
            return redirect()->route('manage_product.index')->with('error', 'Tidak bisa menghapus kategori karena masih ada produk.');
        }

        $category->delete();

        return redirect()->route('manage_product.index')->with('success', 'Category deleted!');
    }
}
