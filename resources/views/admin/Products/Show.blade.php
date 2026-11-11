@extends('layouts.admin')

@section('content')
<h3 class="mb-3">Detail Produk</h3>

<div class="card p-4">

    <div class="d-flex justify-content-center align-items-center gap-5">

        <!-- TEXT -->
        <div>
            <p><strong>Nama:</strong> {{ $product->name }}</p>
            <p><strong>Deskripsi:</strong> {{ $product->description }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p><strong>Stok:</strong> {{ $product->stock }}</p>
        </div>

        <!-- GAMBAR -->
        <div>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     class="img-fluid rounded shadow"
                     style="width: 200px; height: auto;">
            @endif
        </div>

    </div>

</div>
@endsection