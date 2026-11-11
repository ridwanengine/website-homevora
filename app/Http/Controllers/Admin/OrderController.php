<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')
            ->latest()
            ->get()
            ->map(function ($order) {
                $customer = User::find($order->customer_id);
                $order->customer_name = $customer->name ?? 'Unknown';
                $order->customer_email = $customer->email ?? '-';
                $order->customer_phone = $customer->phone ?? '-';

                foreach ($order->items as $item) {
                    $product = \App\Models\Product::find($item->product_id);
                    $item->product_name = $product->name ?? 'Product Deleted';
                    $item->subtotal = $item->quantity * $item->price;
                }

                return $order;
            });

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        if ($request->status == 'shipped') {
            $order->update(['shipped_at' => now()]);
        }

        return back()->with('success', 'Status pesanan berhasil diupdate');
    }

    // method hapus
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Hapus semua item yang terkait dengan order
        $order->items()->delete();

        // Hapus order
        $order->delete();

        return redirect()
            ->back()
            ->with('success', 'Pesanan berhasil dihapus');
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    // Konfirmasi pembayaran
    public function confirmPayment($id)
    {
        $order = Order::with('items')->findOrFail($id);

        DB::transaction(function () use ($order) {

            foreach ($order->items as $item) {

                $product = Product::find($item->product_id);

                // cek stok
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Stok {$product->name} tidak cukup");
                }

                $product->stock -= $item->quantity;
                $product->save();
            }

            $order->payment_status = 'success';
            $order->status = 'diproses';
            $order->save();
        });

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi');
    }


    // Batal konfirmasi pembayaran
    public function cancelConfirmation($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        DB::transaction(function () use ($order) {

            // kalau sebelumnya sudah success, kembalikan stok
            if ($order->payment_status == 'success') {
                foreach ($order->items as $item) {
                    $product = $item->product;
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }

            $order->payment_status = 'pending';
            $order->save();
        });

        return back()->with('success', 'Konfirmasi pembayaran dibatalkan.');
    }
}
