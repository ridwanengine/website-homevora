<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // tampilkan cart
    public function index()
    {
        $cart = session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // tambah produk ke cart
    public function add(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = (string) $request->id;

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += (int) $request->qty;
        } else {
            $cart[$id] = [
                'id'    => $id,
                'name'  => $request->name,
                'price' => $request->price,
                'image' => $request->image,
                'qty' => (int) $request->qty,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function remove(Request $request)
    {
        $id = $request->id;

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // hapus item
    public function removeSelected(Request $request)
    {
        $ids = $request->ids;

        $cart = session()->get('cart', []);

        foreach ($ids as $id) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true
        ]);
    }

    // kosongkan cart
    public function clear()
    {
        session::forget('cart');

        return redirect()->back()->with('success', 'Keranjang dikosongkan');
    }

    // hapus item terpilih
    public function deleteSelected(Request $request)
    {
        $cart = session::get('cart', []);

        $ids = explode(',', $request->ids);

        foreach ($ids as $id) {
            if (isset($cart[$id])) {
                unset($cart[$id]);
            }
        }

        session::put('cart', $cart);

        return redirect()->back()->with('success', 'Produk terpilih berhasil dihapus');
    }

    public function updateQty(Request $request)
    {
        $cart = session::get('cart', []);

        $id = $request->id;
        $qty = (int) $request->qty;

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = max(1, $qty);
            session::put('cart', $cart);
        }

        return response()->json(['success' => true]);
    }
}
