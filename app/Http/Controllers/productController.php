<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Tampilkan halaman home dengan produk terbaru di hero dan list produk lainnya
    public function tampilHome()
    {
        // Produk terbaru (1 produk) beserta merk dan stock-nya
        $latestProduct = Product::with(['merk', 'stock'])
                            ->orderBy('created_at', 'desc')
                            ->first();

        // Ambil 8 produk terbaru lainnya untuk ditampilkan, juga beserta merk dan stock
        $products = Product::with(['merk', 'stock'])
                    ->orderBy('created_at', 'desc')
                    ->take(8)
                    ->get();

        return view('pages.pembeli.home_page', compact('latestProduct', 'products'));
    }

    // Tampilkan produk berdasarkan kode kategori yang aktif
    public function showCategory($categoryCode)
    {
        $products = Product::where('category_code', $categoryCode)
                    ->whereHas('category', function($query) {
                        $query->where('status', 'ON');
                    })
                    ->with(['merk', 'category', 'stock'])
                    ->get();

        return view('pages.pembeli.category', compact('products', 'categoryCode'));
    }

    // Tampilkan detail produk berdasarkan code_product (bukan ID)
    public function show($code_product)
    {
        $product = Product::with(['merk', 'category', 'stock'])
                    ->where('code_product', $code_product)
                    ->firstOrFail();

        return view('pages.pembeli.detail_product', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::with('category', 'merk')
            ->where('name', 'like', '%' . $query . '%')
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                ->orWhere('code', 'like', '%' . $query . '%');
            })
            ->orWhereHas('merk', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                ->orWhere('code', 'like', '%' . $query . '%');
            })
            ->get();

        return view('pages.pembeli.search_results', compact('products', 'query'));
    }

}
