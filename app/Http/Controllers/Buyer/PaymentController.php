<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function showPaymentPage()
    {
        $user = Auth::user();
        $latestOrderCode = session('latest_order_code');

        if (!$latestOrderCode || !session('payment_success')) {
            return redirect()->route('cart')->with('error', 'Checkout belum selesai.');
        }

        $order = Order::where('order_code', $latestOrderCode)
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            return redirect()->route('cart')->with('error', 'Pesanan tidak ditemukan.');
        }

        $paymentMethods = Payment::all();

        return view('pages.pembeli.payment', [
            'user' => $user,
            'order' => $order,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    public function uploadPaymentProof(Request $request)
    {
        $request->validate([
            'order_code' => 'required|exists:orders,order_code',
            'payment_id' => 'required|exists:payments,id',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $order = Order::where('order_code', $request->order_code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // ⏰ Cek apakah deadline sudah lewat
        if ($order->expired_at && now()->greaterThan($order->expired_at)) {
            // Update status jadi 'rejected' karena timeout
            $order->update(['status' => 'rejected']);

            // Hapus session supaya user gak bisa masuk ke halaman pembayaran lagi
            session()->forget(['latest_order_code', 'payment_success']);

            return redirect()->route('home_page')->with('error', 'Waktu pembayaran telah habis. Pesanan dibatalkan.');
        }

        // ✅ Lanjut upload bukti
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $order->update([
            'payment_id' => $request->payment_id,
            'payment_proof' => $path,
            'status' => 'waiting', // nunggu konfirmasi admin
        ]);

        // Hapus session agar user tidak bisa akses ulang halaman ini tanpa checkout ulang
        session()->forget(['latest_order_code', 'payment_success']);

        return redirect()->route('invoice.show', ['order_code' => $order->order_code])
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi admin.');
        }

}

