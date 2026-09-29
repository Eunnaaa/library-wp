<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\BukuController as AdminBukuController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Member\BookingController as MemberBookingController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Member\TempController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public & Catalog
Route::get('/', [MemberController::class, 'index'])->name('member.index')->middleware('isMember');
Route::get('detail-buku/{buku}', [MemberController::class, 'detailBuku'])->name('member.detailBuku')->middleware('isMember');

// Guest Authentication Routes
Route::middleware(['guest', 'throttle:5,1'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Logout
Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
});

// Member Routes
Route::middleware(['auth', 'isMember'])->group(function () {
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/profil', [MemberController::class, 'tampilProfil'])->name('profil');
        Route::put('/profil', [MemberController::class, 'updateProfil']);
        Route::get('/ganti-password', [MemberController::class, 'tampilGantiPassword'])->name('ganti-password');
        Route::put('/ganti-password', [MemberController::class, 'updateGantiPassword']);

        // Keranjang & Booking
        Route::post('tambah-ke-keranjang', [TempController::class, 'tambahKeranjang'])->name('tambahKeranjang');
        Route::get('data-keranjang/{user?}', [TempController::class, 'dataKeranjang'])->name('dataKeranjang');
        Route::delete('hapus-keranjang/{buku}/{user?}', [TempController::class, 'hapusKeranjang'])->name('hapusKeranjang');
        Route::post('simpan-booking', [TempController::class, 'simpanBooking'])->name('simpanBooking');
        Route::get('data-booking/{user?}', [MemberBookingController::class, 'dataBooking'])->name('dataBooking');
        Route::get('booking-pdf/{user?}', [MemberBookingController::class, 'bookingPdf'])->name('bookingPdf');
    });
});

// Admin Routes
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [AdminDashboardController::class, 'profil'])->name('profil');
        Route::put('/profil', [AdminDashboardController::class, 'updateProfil']);
        Route::get('/ganti-password', [AdminDashboardController::class, 'tampilGantiPassword'])->name('ganti-password');
        Route::put('/ganti-password', [AdminDashboardController::class, 'updateGantiPassword']);

        // Data Master
        Route::prefix('master')->name('master.')->group(function () {
            Route::resource('user', UserController::class);
            Route::resource('kategori', AdminKategoriController::class);
            Route::resource('buku', AdminBukuController::class);
        });

        // Data Transaksi
        Route::prefix('transaksi')->name('transaksi.')->group(function () {
            Route::resource('booking', AdminBookingController::class);
            Route::resource('peminjaman', PinjamController::class);
            Route::get('pengembalian', [PinjamController::class, 'pengembalian_index'])->name('peminjaman.pengembalian');
            Route::get('peminjaman-data', [PinjamController::class, 'getData'])->name('peminjaman.data');
            Route::get('export-pdf-pinjam', [PinjamController::class, 'exportPdfPinjam'])->name('pinjam.exportPdfPinjam');
            Route::get('export-excel-pinjam', [PinjamController::class, 'exportExcelPinjam'])->name('pinjam.exportExcelPinjam');
            Route::match(['put', 'post'], 'pinjam/kembalikanBuku/{no_pinjam}/{id_buku}', [PinjamController::class, 'kembalikanBuku'])->name('pinjam.kembalikanBuku');
        });
    });
});
