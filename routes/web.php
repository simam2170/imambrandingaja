<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Jaringan;

/*
|--------------------------------------------------------------------------
| BERANDA / FRONTEND UMUM
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('index'); // resources/views/index.blade.php
})->name('beranda');

Route::get('/hal-tentangkami', function () {
    return view('hal-tentangkami'); // resources/views/hal-tentangkami.blade.php
})->name('tentangkami');

/*
|--------------------------------------------------------------------------
| REDIRECTS & SHORTCUTS
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return redirect()->route('beranda');
})->name('login');

/*
|--------------------------------------------------------------------------
| USER AREA
|--------------------------------------------------------------------------
*/
Route::prefix('user')->group(function () {
    Route::get('/orders', [App\Http\Controllers\User\UserOrderController::class, 'index'])->name('user.pesanan');
    Route::post('/checkout', [App\Http\Controllers\User\UserOrderController::class, 'store'])->name('user.checkout.store');

    // Maintain existing for UI compatibility
    Route::get('/dashboard/{id?}', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/profile/{id?}', [App\Http\Controllers\User\ProfileController::class, 'index'])->name('user.profile');
    Route::post('/profile/{id?}', [App\Http\Controllers\User\ProfileController::class, 'update'])->name('user.profile.update');
    Route::get('/keranjang', [App\Http\Controllers\User\CartController::class, 'index'])->name('user.keranjang');
    Route::post('/cart/add', [App\Http\Controllers\User\CartController::class, 'store'])->name('user.cart.add');
    Route::patch('/cart/update/{id}', [App\Http\Controllers\User\CartController::class, 'update'])->name('user.cart.update');
    Route::delete('/cart/delete/{id}', [App\Http\Controllers\User\CartController::class, 'destroy'])->name('user.cart.delete');
    Route::get('/checkout', function () {
        $user = Auth::user() ?? \App\Models\User::where('role', 'user')->first();
        return view('user.checkout', compact('user'));
    })->name('user.checkout');
    Route::get('/invoice/{id}', [App\Http\Controllers\User\UserOrderController::class, 'show'])->name('user.invoice');
    Route::post('/invoice/{id}/upload', [App\Http\Controllers\PaymentController::class, 'upload'])->name('user.payment.upload');
    Route::post('/invoice/{id}/cancel', [App\Http\Controllers\User\UserOrderController::class, 'cancel'])->name('user.order.cancel');
    Route::get('/mitra/{id}', [App\Http\Controllers\User\JaringanController::class, 'show'])->name('user.mitra');
    Route::get('/layanan/{id}', [App\Http\Controllers\User\LayananController::class, 'show'])->name('user.layanan.show');
    Route::post('/orders/{id}/review', [App\Http\Controllers\User\UserReviewController::class, 'store'])->name('user.review.store');
});

/*
|--------------------------------------------------------------------------
| MITRA (JARINGAN) AREA
|--------------------------------------------------------------------------
*/
Route::prefix('mitra')->group(function () {
    Route::get('/{id}/orders', [App\Http\Controllers\Mitra\JaringanOrderController::class, 'index'])->name('mitra.pesanan');
    Route::post('/orders/{id}/complete', [App\Http\Controllers\Mitra\JaringanOrderController::class, 'complete'])->name('mitra.pesanan.complete');

    // Maintain existing for UI compatibility
    Route::get('/dashboard/{id?}', [App\Http\Controllers\Mitra\DashboardController::class, 'index'])->name('mitra.dashboard');
    Route::get('/pesanan/detail/{id}', [App\Http\Controllers\Mitra\JaringanOrderController::class, 'show'])->name('mitra.pesanan.show');
    Route::get('/layanan-saya', [App\Http\Controllers\Mitra\ProfilController::class, 'layanan'])->name('mitra.layanan');
    Route::post('/layanan-saya', [App\Http\Controllers\Mitra\ProfilController::class, 'storeLayanan'])->name('mitra.layanan.store');
    Route::get('/pendapatan', [App\Http\Controllers\Mitra\PendapatanController::class, 'index'])->name('mitra.pendapatan');
    Route::get('/profil', [App\Http\Controllers\Mitra\ProfilController::class, 'index'])->name('mitra.profil');
    Route::post('/profil', [App\Http\Controllers\Mitra\ProfilController::class, 'update'])->name('mitra.profil.update');
    Route::get('/user/{id}', [App\Http\Controllers\User\ProfileController::class, 'showPublic'])->name('mitra.user.profile');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/orders', [App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('admin.pesanan.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Admin\AdminOrderController::class, 'show'])->name('admin.pesanan.show');
    Route::post('/orders/{id}/review/{status}', [App\Http\Controllers\Admin\AdminOrderController::class, 'verifyPayment'])->name('admin.payment.verify');
    Route::post('/orders/{id}/payout', [App\Http\Controllers\Admin\AdminOrderController::class, 'uploadPayoutProof'])->name('admin.payout.upload');
    Route::get('/user/{id}', [App\Http\Controllers\User\ProfileController::class, 'showPublic'])->name('admin.user.profile');
});
