<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('customer_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product'])
            ->findOrFail($id);

        return view('orders.detail', compact('order'));
    }

    public function cancel(Order $order)
    {
        // Pastikan hanya pesanan pending atau diproses yang bisa dibatalkan
        if (!in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // Fitur Konfirmasi Penerimaan Pesanan
    public function markAsReceived($id)
    {
        DB::transaction(function () use ($id) {

            $order = Order::with('items')->findOrFail($id);

            if ($order->status !== 'shipped') {
                return;
            }

            foreach ($order->items as $item) {

                $product = Product::find($item->product_id);

                if ($product) {

                    $product->stock -= $item->jumlah;

                    if ($product->stock < 0) {
                        $product->stock = 0;
                    }

                    $product->save();
                }
            }

            $order->status = 'completed';
            $order->save();
        });

        return back()->with('success', 'Pesanan berhasil diterima');
    }

    // Fitur Beli Lagi
    public function reorder(Order $order)
    {
        $cart = session()->get('cart', []);
        $stokHabis = [];

        foreach ($order->items as $item) {

            $product = Product::find($item->product_id);

            // Produk sudah dihapus atau stok habis
            if (!$product || $product->stock <= 0) {
                $stokHabis[] = $item->product->name;
                continue;
            }

            $qty = min($item->jumlah, $product->stock);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['qty'] += $qty;
            } else {
                $cart[$product->id] = [
                    "id" => $product->id,
                    "name" => $product->name,
                    "price" => $product->price,
                    "qty" => $qty,
                    "image" => $product->image,
                ];
            }
        }

        session()->put('cart', $cart);

        if (count($stokHabis) == count($order->items)) {
            return redirect()->route('orders.index')
                ->with([
                    'error' => 'Produk pada pesanan ini sudah habis stok.',
                    'error_order_id' => $order->id,
                ]);
        }

        if (!empty($stokHabis)) {
            return redirect()->route('cart.index')
                ->with('warning', 'Beberapa produk tidak ditambahkan karena stok habis.');
        }

        return redirect()->route('cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }
}
