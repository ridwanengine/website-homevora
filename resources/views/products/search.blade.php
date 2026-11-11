@extends('layouts.app')

@section('title', 'Hasil Pencarian')

@section('content')

    <div class="container py-5">

        <h3 class="mb-4">
            Hasil pencarian :
            <strong>"{{ $keyword }}"</strong>
        </h3>

        @if ($products->count())

            <div class="row">

                @foreach ($products as $product)
                    <div class="col-md-3 mb-4">

                        <div class="card h-100 shadow-sm">

                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                style="height:220px;object-fit:cover;">

                            <div class="card-body">

                                <h5>{{ $product->name }}</h5>

                                <p class="text-muted">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>

                                <a href="{{ route('produk.show', $product->id) }}" class="btn btn-orange w-100">

                                    Lihat Produk

                                </a>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

            <div class="mt-3">
                {{ $products->links() }}
            </div>
        @else
            <div class="alert alert-warning">

                Produk dengan kata kunci
                <strong>"{{ $keyword }}"</strong>
                tidak ditemukan.

            </div>

        @endif

    </div>

@endsection
