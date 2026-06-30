<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Tambah produk ke keranjang
    public function addToCart(Request $request, $code_product)
    {
        $product = Product::where('code_product', $code_product)->first();

        if (!$product) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Produk tidak ditemukan.'], 404)
                : redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $quantity = max((int) $request->input('quantity', 1), 1);
        $stock = $product->stock;

        if (!$stock || $stock->stock <= 0) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Stok tidak tersedia.'], 400)
                : redirect()->back()->with('error', 'Stok tidak tersedia.');
        }

        $userEmail = Auth::user()->email;

        // Hitung total quantity yang sudah ada di keranjang user untuk produk ini
        $currentQtyInCart = Cart::where('code_product', $code_product)
            ->where('user_email', $userEmail)
            ->sum('quantity');

        // Jika penambahan akan melebihi stok, tolak
        if ($currentQtyInCart + $quantity > $stock->stock) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Jumlah di keranjang melebihi stok yang tersedia.'], 400)
                : redirect()->back()->with('error', 'Jumlah di keranjang melebihi stok yang tersedia.');
        }

        $subtotal = $product->price * $quantity;

        $existing = Cart::where('code_product', $code_product)
            ->where('user_email', $userEmail)
            ->first();

        if ($existing) {
            $existing->quantity += $quantity;
            $existing->subtotal = $existing->quantity * $product->price;
            $existing->save();
        } else {
            Cart::create([
                'code_cart' => Str::uuid(),
                'user_email' => $userEmail,
                'code_product' => $code_product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);
        }

        $cartCount = Cart::where('user_email', $userEmail)->count();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Produk berhasil ditambahkan ke keranjang.',
                'cartCount' => $cartCount,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    // Tampilkan isi keranjang
    public function showCart()
    {
        $userEmail = Auth::user()->email;

        $cartItems = Cart::with('product')
            ->where('user_email', $userEmail)
            ->get();

        return view('pages.pembeli.cart', ['cart' => $cartItems]);
    }

    // Update jumlah produk di keranjang (tanpa sentuh stok)
    public function updateCart(Request $request, $code_product)
    {
        $userEmail = Auth::user()->email;

        $cart = Cart::with('product')
            ->where('code_product', $code_product)
            ->where('user_email', $userEmail)
            ->first();

        if (!$cart) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Item tidak ditemukan.'], 404);
            }
            return redirect()->route('cart')->with('error', 'Item tidak ditemukan.');
        }

        $quantity = max((int) $request->input('quantity', 1), 1);
        $stock = $cart->product->stock;

        if (!$stock) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Stok tidak tersedia.'], 400);
            }
            return redirect()->route('cart')->with('error', 'Stok tidak tersedia.');
        }

        // Hitung total quantity user lainnya (jika ada, seharusnya cuma 1 row, tapi tetap aman)
        $otherQtyInCart = Cart::where('user_email', $userEmail)
            ->where('code_product', $code_product)
            ->where('code_cart', '!=', $cart->code_cart)
            ->sum('quantity');

        $totalQtyIfUpdated = $otherQtyInCart + $quantity;

        if ($totalQtyIfUpdated > $stock->stock) {
            $message = 'Jumlah melebihi stok tersedia.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 400);
            }
            return redirect()->route('cart')->with('error', $message);
        }

        $cart->quantity = $quantity;
        $cart->subtotal = $quantity * $cart->product->price;
        $cart->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'new_subtotal' => $cart->subtotal
            ]);
        }

        return redirect()->route('cart')->with('success', 'Keranjang diperbarui.');
    }

    // Hapus produk dari keranjang (tanpa tambah stok)
    public function removeFromCart($code_product)
    {
        $userEmail = Auth::user()->email;

        $cart = Cart::where('code_product', $code_product)
            ->where('user_email', $userEmail)
            ->first();

        if ($cart) {

            $cart->delete();
        }

        return redirect()->route('cart')->with('success', 'Produk dihapus dari keranjang.');
    }

}

