<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;


Route::get('/', [HomeController::class, 'index'])
    ->name('Home');


// Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('Home');
})->name('logout');


// Password Reset

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');

// Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
//     ->name('password.reset');

// Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
//     ->name('password.update');

// Register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');

Route::get('/products/search', [ProdukController::class, 'search'])
    ->name('products.search');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

// cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::post('/cart/add', [CartController::class, 'add'])
    ->middleware('auth')
    ->name('cart.add');

Route::post('/cart/remove', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::post('/cart/remove-selected', [CartController::class, 'removeSelected'])
    ->name('cart.removeSelected');

Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/cart/delete', [CartController::class, 'deleteSelected']);

Route::post('/cart/update-qty', [CartController::class, 'updateQty']);


// checkout
Route::post('/checkout/buy-now', [CheckoutController::class, 'buyNow'])
    ->name('checkout.buy-now');

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->middleware('auth')
    ->name('checkout');

Route::post('/checkout', [CheckoutController::class, 'store'])
    ->middleware('auth')
    ->name('checkout.store');

Route::post('/checkout/select', [CheckoutController::class, 'select'])
    ->middleware('auth')
    ->name('checkout.select');

// pesanan (hanya untuk user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
});

// Payment
Route::get(
    '/payment/{id}',
    [CheckoutController::class, 'payment']
)->middleware('auth')
    ->name('payment');

Route::post(
    '/payment/upload/{id}',
    [PaymentController::class, 'upload']
)
    ->name('payment.upload');


// Profile
Route::middleware('auth')->group(function () {

    Route::get('/Profil', [ProfilController::class, 'index'])
        ->name('Profil');

    Route::put('/Profil/update', [ProfilController::class, 'update'])
        ->name('Profil.update');

    Route::post('/profil/upload-photo', [ProfilController::class, 'uploadPhoto'])
        ->name('Profil.uploadPhoto');

    Route::put('/Profil/change-password', [ProfilController::class, 'changePassword'])
        ->name('Profil.changePassword');

    Route::put('/Profil/update-address', [ProfilController::class, 'updateAddress'])
        ->name('Profil.updateAddress');
});


// pesanan
Route::get('/pesanan/{id}', [OrderController::class, 'show'])
    ->name('orders.detail');

Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])
    ->name('orders.cancel');

Route::get('/order/{order}/reorder', [OrderController::class, 'reorder'])
    ->name('order.reorder');

Route::put(
    '/orders/{id}/received',
    [OrderController::class, 'markAsReceived']
)
    ->name('orders.received');

// Ulasan
Route::get('/reviews/create/{order}', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

Route::put('/reviews/{review}', [ReviewController::class, 'update'])
    ->name('reviews.update');
