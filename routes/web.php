<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScorecardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

// Public / Guest Only Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk/nik', [AuthController::class, 'loginNik'])->name('auth.nik');
    Route::post('/masuk/admin', [AuthController::class, 'loginAdmin'])->name('auth.admin');
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    Route::post('/auth/otp/kirim', [AuthController::class, 'sendOtp'])->name('auth.otp.send');
    Route::get('/auth/otp/verifikasi', [AuthController::class, 'showVerifyOtp'])->name('auth.otp.verify');
    Route::post('/auth/otp/verifikasi', [AuthController::class, 'verifyOtp'])->name('auth.otp.check');
});

Route::get('/auth/tamu', [AuthController::class, 'guest'])->name('auth.guest');
Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

Route::get('/og-image', fn () => view('og-image'))->name('og-image');

// Protected Routes (Must be logged in as Warga or Admin, or via guest session)
Route::middleware('role.auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('lacak')->name('tracker.')->group(function () {
        Route::get('/', [TrackerController::class, 'index'])->name('index');
        Route::get('/{receipt}', [TrackerController::class, 'show'])
            ->middleware('throttle:tracker')
            ->name('show');
    });

    Route::prefix('lapor')->name('report.')->group(function () {
        Route::get('/', [ReportController::class, 'choose'])->name('choose');
        Route::get('/pungli', [ReportController::class, 'createExtortion'])->name('extortion.create');
        Route::post('/pungli', [ReportController::class, 'storeExtortion'])->name('extortion.store');
        Route::get('/sanggah', [ReportController::class, 'createDispute'])->name('dispute.create');
        Route::post('/sanggah', [ReportController::class, 'storeDispute'])->name('dispute.store');
        Route::get('/sukses', [ReportController::class, 'success'])->name('success');
    });

    Route::prefix('tiket')->name('ticket.')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::post('/akses', [TicketController::class, 'access'])->name('access');
        Route::get('/{ticket}', [TicketController::class, 'show'])->name('show');
        Route::post('/{ticket}/tanggapan', [TicketController::class, 'reply'])->name('reply');
    });

    Route::get('/peta', [MapController::class, 'index'])->name('map.index');

    Route::prefix('scorecard')->name('scorecard.')->group(function () {
        Route::get('/', [ScorecardController::class, 'index'])->name('index');
        Route::get('/{agency:slug}', [ScorecardController::class, 'show'])->name('show');
    });

    Route::get('/data', [ScorecardController::class, 'data'])->name('data.index');
    Route::get('/data/unduh/{dataset}', [ScorecardController::class, 'export'])->name('data.export');

    Route::get('/tentang', fn () => view('pages.about'))->name('about');
    Route::get('/ketentuan', fn () => view('pages.terms'))->name('terms');
});
