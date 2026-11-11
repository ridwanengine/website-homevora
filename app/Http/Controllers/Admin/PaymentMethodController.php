<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $payments = PaymentMethod::latest()->get();

        return view(
            'admin.Payment.index',
            compact('payments')
        );
    }

    public function create()
    {
        return view('admin.Payment.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'account_number' => 'required',
                'account_name' => 'required',
            ]
        );

        PaymentMethod::create([
            'name' => $request->name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
        ]);

        return redirect()
            ->route('admin.payment.index')
            ->with(
                'success',
                'Metode pembayaran berhasil ditambahkan'
            );
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $payment = PaymentMethod::findOrFail($id);

        $payment->update([
            'name' => $request->name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
        ]);

        return redirect()
            ->route('admin.payment.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $payment = PaymentMethod::findOrFail($id);

        $payment->delete();

        return redirect()
            ->route('admin.payment.index')
            ->with(
                'success',
                'Data berhasil dihapus'
            );
    }
}
