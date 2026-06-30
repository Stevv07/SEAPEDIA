<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    // Tampilkan semua kategori untuk admin
    public function index()
    {
        $categories = Category::all();
        return view('pages.admin.category.category', compact('categories'));
    }

    public function create()
    {
        return redirect()->route('category.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:categories,code',
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil disimpan');
    }

    public function edit($code)
    {
        $category = Category::where('code', $code)->firstOrFail();
        return response()->json($category);
    }

    public function update(Request $request, $code)
    {
        $category = Category::where('code', $code)->firstOrFail();

        $request->validate([
            'code' => 'required|string|max:10|unique:categories,code,' . $category->code . ',code',
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($code)
    {
        $category = Category::where('code', $code)->firstOrFail();
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus');
    }

    // Tampilkan produk berdasarkan kategori untuk pembeli
    public function show($code)
    {
        $category = Category::where('code', $code)->firstOrFail();

        $products = Product::where('category_code', $code)->get();

        return view('pages.pembeli.category', compact('category', 'products'));
    }
}
