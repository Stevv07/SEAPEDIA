<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function show($order_code)
    {
        // Ambil data order dari tabel orders beserta relasi user dan payment
        $order = Order::with(['user', 'payment'])
            ->where('order_code', $order_code)
            ->firstOrFail();

        // Ambil data produk dari tabel order_items beserta relasi product
        $invoiceProducts = OrderItem::with('product')
            ->where('order_code', $order_code)
            ->get();

        // Hitung subtotal
        $subTotal = $invoiceProducts->sum('subtotal');

        return view('pages.pembeli.invoice', compact('order', 'invoiceProducts', 'subTotal'));
    }
}