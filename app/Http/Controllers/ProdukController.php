<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('produk.index', compact('products'));
    }

    // Fitur Pencarian Produk
    public function search(Request $request)
    {
        $keyword = trim($request->search);

        if ($keyword == '') {
            return redirect()->route('produk.index')
                ->with('error', 'Silakan masukkan kata kunci pencarian.');
        }

        $products = Product::where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('description', 'LIKE', "%{$keyword}%")
            ->paginate(12);

        return view('products.search', compact('products', 'keyword'));
    }

    public function show($id)
    {
        $product = Product::with(['reviews.user'])->findOrFail($id);

        $reviews = $product->reviews;

        $averageRating = $reviews->avg('rating');
        $totalReview = $reviews->count();

        $star5 = $reviews->where('rating', 5)->count();
        $star4 = $reviews->where('rating', 4)->count();
        $star3 = $reviews->where('rating', 3)->count();
        $star2 = $reviews->where('rating', 2)->count();
        $star1 = $reviews->where('rating', 1)->count();

        return view('produk.product-detail', compact(
            'product',
            'reviews',
            'averageRating',
            'totalReview',
            'star5',
            'star4',
            'star3',
            'star2',
            'star1'
        ));
    }
}
