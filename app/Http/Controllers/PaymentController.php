<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function upload(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $order = Order::findOrFail($id);

        // simpan file
        $file = $request->file('payment_proof');

        $filename = time() . '.' . $file->getClientOriginalExtension();

        $file->move(public_path('payments'), $filename);

        // simpan ke database
        $order->update([
            'payment_proof' => $filename
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload');
    }
}