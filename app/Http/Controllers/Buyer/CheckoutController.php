<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function showCheckout(Request $request)
    {
        $user = Auth::user();

        // ⛑️ Pastikan selalu terdefinisi
        $showProfileWarning = false;

        if (!$user->address || !$user->phone) {
            $showProfileWarning = true;
        }

        $selectedItems = $request->input('selected_items', []);
        if (empty($selectedItems)) {
            return redirect()->route('cart')->with('error', 'Pilih item terlebih dahulu.');
        }

        $cart = Cart::with('product')
            ->where('user_email', $user->email)
            ->whereIn('code_cart', $selectedItems)
            ->get();

        if ($cart->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Item tidak ditemukan.');
        }

        $total = $cart->sum('subtotal');

        session([
            'checkout_data' => [
                'selected_items' => $selectedItems,
                'total_price' => $total,
            ]
        ]);

        return view('pages.pembeli.checkout', compact('user', 'cart', 'total', 'showProfileWarning'));
    }

    public function toPaymentPage(Request $request)
    {
        $user = Auth::user();
        $selectedItems = $request->input('selected_items', []);

        // Ambil item yang dipilih dari keranjang
        $cartItems = Cart::with('product')
            ->where('user_email', $user->email)
            ->whereIn('code_cart', $selectedItems)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Tidak ada item yang dipilih untuk checkout.');
        }

        // ✅ Validasi stok sebelum lanjut
        foreach ($cartItems as $item) {
            $stock = Stock::where('code_product', $item->code_product)->first();
            if (!$stock || $stock->stock < $item->quantity) {
                return redirect()->route('cart')->with('error', 'Stok tidak mencukupi untuk produk: ' . $item->product->name);
            }
        }

        // Hitung total harga dari item terpilih
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Generate kode unik pesanan
        $orderCode = 'ORD-' . strtoupper(uniqid());

        // Simpan order ke database
        $order = Order::create([
            'order_code'   => $orderCode,
            'user_id'      => $user->id,
            'total_price'  => $total,
            'status'       => 'pending_payment',
            'expired_at' => now()->addMinutes(4), // ⏰ batas waktu pembayaran
        ]);

        // Simpan detail item ke tabel order_items dan kurangi stok
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_code'    => $orderCode,
                'code_product'  => $item->code_product,
                'quantity'      => $item->quantity,
                'order_price'   => $item->product->price,
                'subtotal'      => $item->subtotal,
            ]);

            // Kurangi stok produk
            $stockRecord = Stock::where('code_product', $item->code_product)->first();
            if ($stockRecord) {
                $stockRecord->decrement('stock', $item->quantity);
            }
        }

        // Hapus dari keranjang setelah checkout
        Cart::whereIn('code_cart', $selectedItems)
            ->where('user_email', $user->email)
            ->delete();

        // Simpan ke session untuk akses sementara
        session([
            'latest_order_code' => $orderCode,
            'payment_success' => true,
        ]);

        return redirect()->route('payment.page');
    }
}
