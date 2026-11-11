<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentMethodController;


Route::name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {

        Route::get('/login', [LoginController::class, 'showLoginForm'])
            ->name('login');

        Route::post('/login', [LoginController::class, 'login'])
            ->name('login.submit');
    });

    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('products', ProductController::class);

        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{id}', [OrderController::class, 'show'])
            ->name('orders.show');

        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.update-status');

        Route::put('/orders/{id}/tracking', [OrderController::class, 'updateTracking'])
            ->name('orders.update-tracking');

        Route::post('/logout', [LoginController::class, 'logout'])
            ->name('logout');

        Route::resource(
            'payment',
            PaymentMethodController::class
        );
    });
});

Route::delete(
    '/admin/orders/{id}',
    [OrderController::class, 'destroy']
)->name('admin.orders.destroy');

Route::put(
    '/admin/orders/{id}/confirm-payment',
    [OrderController::class, 'confirmPayment']
)->name('admin.orders.confirm-payment');

Route::put(
    '/admin/orders/{id}/cancel-confirmation',
    [OrderController::class, 'cancelConfirmation']
)
    ->name('admin.orders.cancel-confirmation');
