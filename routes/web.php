<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Routes untuk Semua Pengguna yang Sudah Login
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // 🏠 Halaman utama (daftar produk)
    Route::get('/', [ProdukController::class, 'index'])->name('produk.index');

    // 💳 Fitur pembelian produk
    Route::get('/produk/{id}/buy', [ProdukController::class, 'showBuyForm'])->name('produk.buy');
    Route::post('/produk/{id}/buy', [ProdukController::class, 'processPurchase'])->name('produk.purchase');

    // 🧾 Daftar pembelian user
    Route::get('/my-purchases', [ProdukController::class, 'myPurchases'])
        ->name('purchase.purchases');

    /*
    |--------------------------------------------------------------------------
    | Routes khusus Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {
        // CRUD Produk
        Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        // 💼 Manajemen pembelian (admin) - DUA VERSI
        Route::get('/admin/purchases', [ProdukController::class, 'adminPurchases'])
            ->name('admin.purchases');
            
        // 🎯 MANAGEMENT PEMBELIAN BARU (dengan fitur konfirmasi & tolak)
        Route::get('/management/purchases', [ProdukController::class, 'managementPurchases'])
            ->name('management.purchases');
            
        // ✅ UPDATE STATUS untuk kedua halaman admin
        Route::put('/admin/purchases/{id}/status', [ProdukController::class, 'updatePurchaseStatus'])
            ->name('purchase.updateStatus');
        Route::put('/management/purchases/{id}/status', [ProdukController::class, 'updatePurchaseStatus'])
            ->name('management.updateStatus');

        // 📊 LAPORAN (Optional)
        Route::get('/purchase/report', [ProdukController::class, 'purchaseReport'])
            ->name('purchase.report');
    });
});