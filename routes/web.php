<?php

use Illuminate\Support\Facades\Route;


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
| USER AREA
|--------------------------------------------------------------------------
*/
Route::prefix('user')->group(function () {

    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/profile', function () {
        return view('user.profile');
    })->name('user.profile');

    Route::get('/pesanan', [App\Http\Controllers\User\PesananController::class, 'index'])->name('user.pesanan');

    Route::get('/keranjang', function () {
        return view('user.keranjang');
    })->name('user.keranjang');

    Route::get('/checkout', function () {
        return view('user.checkout');
    })->name('user.checkout');

    Route::get('/invoice', function () {
        return view('user.invoice');
    })->name('user.invoice');

    Route::get('/jaringan/{id}', function ($id) {
        return view('user.jaringan.' . $id);
    })->name('user.jaringan');

    Route::get('/jaringan/layanan/1YTpodcast', function () {
        return view('user.jaringan.layanan.1YTpodcast');
    })->name('user.jaringan.layanan.1YTpodcast');


});

/*
|--------------------------------------------------------------------------
| MITRA AREA (SERVICE PROVIDER)
|--------------------------------------------------------------------------
*/
Route::prefix('mitra')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Mitra\DashboardController::class, 'index'])->name('mitra.dashboard');
    Route::get('/pesanan', [App\Http\Controllers\Mitra\PesananController::class, 'index'])->name('mitra.pesanan');
    Route::get('/pesanan/{id}', [App\Http\Controllers\Mitra\PesananController::class, 'show'])->name('mitra.pesanan.show');
    Route::get('/layanan-saya', [App\Http\Controllers\Mitra\ProfilController::class, 'layanan'])->name('mitra.layanan');
    Route::post('/layanan-saya', [App\Http\Controllers\Mitra\ProfilController::class, 'storeLayanan'])->name('mitra.layanan.store');
    Route::get('/pendapatan', [App\Http\Controllers\Mitra\ProfilController::class, 'pendapatan'])->name('mitra.pendapatan');
    Route::get('/profil', [App\Http\Controllers\Mitra\ProfilController::class, 'index'])->name('mitra.profil');
    Route::post('/profil', [App\Http\Controllers\Mitra\ProfilController::class, 'update'])->name('mitra.profil.update');

    // Action: Upload Hasil
    Route::post('/pesanan/{id}/upload', [App\Http\Controllers\Mitra\PesananController::class, 'upload'])->name('mitra.pesanan.upload');
});
