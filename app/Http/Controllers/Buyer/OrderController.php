<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\SalesReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    // Menampilkan daftar semua order
    public function index()
    {
        $orders = Order::with(['user', 'payment', 'orderItems.product'])
               ->where('status', '!=', 'pending_payment') // ⛔ exclude unpaid orders
               ->latest()
               ->get();
        return view('pages.admin.order', compact('orders'));
    }

    // Konfirmasi pesanan (ubah status menjadi 'sent')
    public function confirm(Order $order)
    {
        $order->status = 'processing';
        $order->save();

        return redirect()->route('order')->with('success', 'Order confirmed successfully.');
    }

    // Tolak pesanan (ubah status menjadi 'rejected')
    public function reject(Order $order)
    {
        $order->status = 'rejected';
        $order->save();

        return redirect()->route('order')->with('error', 'Order rejected.');
    }

    // Update status dan input ke tabel sales_reports jika completed
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:waiting,processing,sent,complete,rejected',
        ]);

        // ✅ Cegah update jika order sudah complete
        if ($order->status === 'complete') {
            return back()->with('error', 'Status tidak bisa diubah karena pesanan sudah complete.');
        }

        $order->status = $validated['status'];
        $order->save();

        // ✅ Jika status selesai (complete), input ke sales_reports
        if ($validated['status'] === 'complete') {
            // Cek apakah order ini sudah pernah dikirim ke sales_report
            $alreadyExists = SalesReport::where('order_code', $order->order_code)->exists();

            if ($alreadyExists) {
                return back()->with('error', 'Data sales report untuk pesanan ini sudah pernah dikirim.');
            }

            // Insert ke sales_reports
            foreach ($order->orderItems as $item) {
                $product = $item->product;

                SalesReport::create([
                    'order_code'      => $order->order_code,
                    'product_code'    => $product->code_product,
                    'product'         => $product->name,
                    'category'        => $product->category,
                    'merk'            => $product->merk,
                    'piece'           => $item->quantity,
                    'price_per_piece' => $item->subtotal / max($item->quantity, 1), // Hindari pembagian 0
                    'date'            => now()->toDateString(),
                ]);
            }
        }

        return back()->with('success', 'Order status updated.');
    }
    
    public function showNotif()
    {
        // Ambil semua order dengan status waiting
        $waitingOrders = Order::with(['user', 'orderItems.product', 'payment'])
                        ->whereIn('status', ['pending_payment', 'waiting'])
                        ->latest()
                        ->get();

            return view('pages.admin.notification', [
            'waitingOrders' => $waitingOrders,
            'waitingOrdersJson' => $waitingOrders->toJson(),
        ]);

    }

}
