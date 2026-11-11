<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $totalOrders = Order::count();

        $totalSales = Order::where('status', 'completed')
            ->sum('total_amount');

        $pendingOrders = Order::where('status', 'pending')
            ->count();

        $processingOrders = Order::where('status', 'processing')
            ->count();

        $totalCustomers = User::where('role', 'customer')
            ->count();

        $recentOrders = Order::with('items')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($order) {

                $order->customer_name =
                    User::find($order->customer_id)->name ?? 'Unknown';

                return $order;
            });

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalSales',
            'pendingOrders',
            'processingOrders',
            'totalCustomers',
            'recentOrders'
        ));
    }
}
