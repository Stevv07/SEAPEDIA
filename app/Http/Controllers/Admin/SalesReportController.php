<?php

namespace App\Http\Controllers\Admin;

use App\Models\product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\SalesReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        // Ambil OrderItem yang memiliki order dengan status 'completed'
        $query = OrderItem::with(['product.category', 'product.merk', 'order'])
            ->whereHas('order', function ($q) {
                $q->where('status', 'complete');
            });

        // Filter tanggal jika diisi
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->start_date)
                  ->whereDate('created_at', '<=', $request->end_date);
            });
        }

        // Filter kategori jika diisi
        if ($request->filled('category')) {
            $query->whereHas('product.category', function ($q) use ($request) {
                $q->where('code', $request->category);
            });
        }

        // Ambil data akhir
        $sales = $query->get();

        return view('pages.admin.sales-report', compact('sales', 'categories'));
    }

    public function bestSeller() {
        $bestSelling = SalesReport::select('product_code', DB::raw('SUM(piece) as total_sold'))
            ->groupBy('product_code')
            ->orderBy('total_sold', 'desc')
            ->take(4)
            ->get();
        
        $codes = $bestSelling->pluck('product_code')->toArray();

        $products = Product::whereIn('code_product', $codes)->get();
        
        $products = $products->map(function ($product) use ($bestSelling) {
            $sold = $bestSelling->firstWhere('product_code', $product->code_product);
            $product->total_sold = $sold ? $sold->total_sold : 0;
            return $product;
        });
        return view('landing', ['bestSelling' => $products]);
    }
}
