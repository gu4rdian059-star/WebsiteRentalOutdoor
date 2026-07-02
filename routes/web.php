<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    PelangganController,
    AlatController,
    TransaksiSewaController,
    DetailSewaController,
    DendaController,
    AuthController,
    CartController
};
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| CART (TIDAK PERLU AUTH UNTUK LIHAT)
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/{cartKey}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

Route::post('/cart/increase/{cartKey}', [CartController::class, 'increaseQty'])
    ->name('cart.increase');

Route::post('/cart/decrease/{cartKey}', [CartController::class, 'decreaseQty'])
    ->name('cart.decrease');

/*
|--------------------------------------------------------------------------
| ALAT (PUBLIC - GUEST BISA LIHAT)
|--------------------------------------------------------------------------
*/
Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');
// NOTE: Route /alat/{alat} dipindahkan ke akhir untuk mencegah conflict dengan /alat/create

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | 🔥 SEWA SEKARANG (AUTO 1 HARI → LANGSUNG CHECKOUT)
    |--------------------------------------------------------------------------
    */
    Route::post('/sewa-sekarang', [CartController::class, 'sewaSekarang'])
        ->name('sewa.sekarang');

    /*
    |--------------------------------------------------------------------------
    | USER PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');

    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [DashboardController::class, 'index'])
            ->name('admin.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | SETTINGS (ADMIN ONLY)
    |--------------------------------------------------------------------------
    */
    Route::prefix('settings')->middleware('role:admin')->group(function () {
        Route::get('/location', [\App\Http\Controllers\SettingsController::class, 'edit'])
            ->name('settings.edit');
        Route::put('/', [\App\Http\Controllers\SettingsController::class, 'update'])
            ->name('settings.update');
    });

    /*
    |--------------------------------------------------------------------------
    | ALAT (ADMIN ONLY - CREATE, EDIT, DELETE)
    |--------------------------------------------------------------------------
    */
    Route::get('/alat/create', [AlatController::class, 'create'])
        ->middleware('role:admin')
        ->name('alat.create');

    Route::post('/alat', [AlatController::class, 'store'])
        ->middleware('role:admin')
        ->name('alat.store');

    Route::get('/alat/{alat}/edit', [AlatController::class, 'edit'])
        ->middleware('role:admin')
        ->name('alat.edit');

    Route::put('/alat/{alat}', [AlatController::class, 'update'])
        ->middleware('role:admin')
        ->name('alat.update');

    Route::delete('/alat/{alat}', [AlatController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('alat.destroy');

    /*
    |--------------------------------------------------------------------------
    | PELANGGAN
    |--------------------------------------------------------------------------
    */

    Route::get('/pelanggan', [PelangganController::class, 'index'])
        ->name('pelanggan.index');

    Route::get('/pelanggan/create', [PelangganController::class, 'create'])
        ->middleware('role:admin')
        ->name('pelanggan.create');

    Route::post('/pelanggan', [PelangganController::class, 'store'])
        ->middleware('role:admin')
        ->name('pelanggan.store');

    Route::get('/pelanggan/{pelanggan}/edit', [PelangganController::class, 'edit'])
        ->middleware('role:admin')
        ->name('pelanggan.edit');

    Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])
        ->middleware('role:admin')
        ->name('pelanggan.update');

    Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('pelanggan.destroy');

    Route::get('/pelanggan/{pelanggan}', [PelangganController::class, 'show'])
        ->name('pelanggan.show');

    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI SEWA
    |--------------------------------------------------------------------------
    */

    // Payment
    Route::post('/transaksi_sewa/payment/page', [TransaksiSewaController::class, 'payment'])
        ->name('transaksi_sewa.payment');

    // Confirm payment (ADMIN)
    Route::post('/transaksi_sewa/{id}/confirm-payment', [TransaksiSewaController::class, 'confirmPayment'])
        ->middleware('role:admin')
        ->name('transaksi_sewa.confirmPayment');

    // Detail transaksi penyewa
    Route::get('/transaksi_sewa/{id}/detail', [TransaksiSewaController::class, 'detailPenyewa'])
        ->name('transaksi_sewa.detail');

    // Struk Pembayaran
    Route::get('/transaksi_sewa/{id}/struk', [TransaksiSewaController::class, 'generateStruk'])
        ->name('transaksi_sewa.struk');
    
    Route::get('/transaksi_sewa/{id}/download-struk', [TransaksiSewaController::class, 'downloadStruk'])
        ->name('transaksi_sewa.downloadStruk');

    Route::resource('transaksi_sewa', TransaksiSewaController::class)
        ->except(['destroy']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY (FULL MODULE)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {

        Route::resource('detail_sewa', DetailSewaController::class);
        Route::resource('denda', DendaController::class);

        // Admin: Fitur Potongan Denda
        Route::get('/denda/{id}/potongan', [DendaController::class, 'editPotongan'])->name('denda.editPotongan');
        Route::post('/denda/{id}/potongan', [DendaController::class, 'storePotongan'])->name('denda.storePotongan');
        Route::delete('/denda/{id}/potongan', [DendaController::class, 'cancelPotongan'])->name('denda.cancelPotongan');

        Route::delete('/transaksi_sewa/{id}', [TransaksiSewaController::class, 'destroy'])
            ->name('transaksi_sewa.destroy');

        Route::post('/alat/delete-all', [AlatController::class, 'destroyAll'])
            ->name('alat.destroyAll');

        Route::post('/pelanggan/delete-all', [PelangganController::class, 'destroyAll'])
            ->name('pelanggan.destroyAll');

        Route::post('/transaksi_sewa/delete-all', [TransaksiSewaController::class, 'destroyAll'])
            ->name('transaksi_sewa.destroyAll');
    });

    /*
    |--------------------------------------------------------------------------
    | PENYEWA ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:penyewa')->group(function () {
        Route::get('/denda-saya', [DendaController::class, 'myDenda'])->name('denda.my');
    });
});

/*
|--------------------------------------------------------------------------
| ALAT SHOW (MUST BE AT END - AFTER /alat/create to avoid 404)
|--------------------------------------------------------------------------
*/
Route::get('/alat/{alat}', [AlatController::class, 'show'])->name('alat.show');
