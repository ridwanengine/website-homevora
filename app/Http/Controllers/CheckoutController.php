<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{

    // HALAMAN CHECKOUT
    public function index(Request $request)
    {
        $cart = Session::get('cart', []);

        $selectedIds = Session::get('selected_items', []);

        $cart = collect($cart)
            ->filter(function ($item) use ($selectedIds) {
                return in_array((string)$item['id'], $selectedIds);
            })
            ->toArray();

        return view('checkout', compact('cart', 'selectedIds'));
    }

    // PROSES CHECKOUT
    public function store(Request $request)
    {
        $request->validate([
            'receiver_name'   => 'required',
            'receiver_phone'  => 'required',
            'address'         => 'required',
            'shipping_method' => 'required',
            'payment_method'  => 'required',
            'total'           => 'required|numeric',
        ]);

        $cart = session('cart', []);

        $selectedIds = Session::get('selected_items', []);

        if (empty($selectedIds)) {
            return back()->with('error', 'Pilih item terlebih dahulu');
        }

        $cart = collect($cart)
            ->filter(function ($item) use ($selectedIds) {
                return in_array((string)$item['id'], $selectedIds);
            })
            ->toArray();

        if (empty($cart)) {
            return back()->with('error', 'Tidak ada item yang dipilih');
        }

        DB::beginTransaction();

        try {

            $paymentMethod = 'COD';

            if ($request->payment_method == 'transfer') {
                $paymentMethod = $request->bank_name;
            }

            if ($request->payment_method == 'ewallet') {
                $paymentMethod = $request->ewallet_name;
            }

            $order = Order::create([
                'customer_id'     => Auth::id(),
                'receiver_name'   => $request->receiver_name,
                'receiver_phone'  => $request->receiver_phone,
                'address'         => $request->address,
                'shipping_method' => $request->shipping_method,
                'payment_method'  => $paymentMethod,
                'total_amount'    => $request->total,

                'status' => $request->payment_method == 'cod'
                    ? 'diproses'
                    : 'pending',

                'payment_deadline' => $request->payment_method != 'cod'
                    ? now()->addHours(24)
                    : null,
            ]);

            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id' => $item['id'] ?? null,
                    'name'       => $item['name'],
                    'price'      => $item['price'],
                    'jumlah'     => $item['qty'],
                    'subtotal'   => $item['price'] * $item['qty'],
                ]);
            }

            DB::commit();

            session()->forget('cart');

            return $request->payment_method == 'cod'
                ? redirect()->route('orders.index')->with('success', 'Pesanan COD berhasil dibuat')
                : redirect()->route('payment', ['id' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // HALAMAN PEMBAYARAN
    public function payment($id)
    {
        $order = Order::where('id', $id)
            ->where('customer_id', Auth::id())
            ->firstOrFail();

        $payment = PaymentMethod::where(
            'name',
            $order->payment_method
        )->first();

        if (!$payment) {
            dd([
                'order_payment' => $order->payment_method,
                'available' => PaymentMethod::pluck('name')
            ]);
        }

        return view('payment', compact('order', 'payment'));
    }


    // BUY NOW
    public function buyNow(Request $request)
    {
        if (!Auth::check()) {

            session([
                'buy_now' => [
                    'id'    => $request->id,
                    'name'  => $request->name,
                    'price' => $request->price,
                    'image' => $request->image,
                    'qty'   => $request->qty,
                ]
            ]);

            return redirect()->route('login');
        }

        session([
            'cart' => [
                $request->id => [
                    'id'    => $request->id,
                    'name'  => $request->name,
                    'price' => $request->price,
                    'image' => $request->image,
                    'qty'   => $request->qty,
                ]
            ]
        ]);

        // TAMBAHKAN INI
        Session::put('selected_items', [(string) $request->id]);

        return redirect()->route('checkout');
    }

    // SELECT CHECKOUT
    public function select(Request $request)
    {
        $selectedIds = json_decode($request->selected_items, true);

        Session::put('selected_items', $selectedIds);

        return redirect()->route('checkout');
    }
}
