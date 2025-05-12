<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SptController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SurveiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');



Route::get('/template', function () {
    return view('templates.ba');
});

// route web.php
Route::get('/test', function () {
    $survei = \App\Models\Survei::with('permohonan.spt.pegawais.user')->latest()->first();
    $spt = optional($survei->permohonan)->spt;

    return view('templates.laporan', compact('survei', 'spt'));
});



Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::get('/guest/inputtracking', [GuestController::class, 'inputtracking'])->name('guest.inputtracking');
Route::post('/guest/tracking', [GuestController::class, 'tracking'])->name('guest.tracking');

Route::resource('survei', SurveiController::class)->except('show');
Route::get('/survei/create/{permohonan_id}', [SurveiController::class, 'create'])->name('survei.create');
Route::get('/survei/laporan', [SurveiController::class, 'indexLaporan'])->name('survei.indexLaporan');
Route::post('/survei/{id}/store-laporan', [SurveiController::class, 'storeLaporan'])->name('survei.storeLaporan');
Route::put('/survei/{id}/update-laporan', [SurveiController::class, 'updateLaporan'])->name('survei.updateLaporan');
Route::delete('/survei/{id}/destroy-laporan', [SurveiController::class, 'destroyLaporan'])->name('survei.destroyLaporan');



Route::resource('permohonan', PermohonanController::class);


Route::resource('pegawai', PegawaiController::class);

Route::get('/spt/index', [SptController::class, 'index'])->name('spt.index');
Route::put('/spt/ditetapkan/{id}', [SptController::class, 'ditetapkan'])->name('spt.ditetapkan');
Route::resource('spt', SptController::class);

Route::get('/spt', function () {
    return view('kadis.spt');
});

Route::get('/berita-acara', [SurveiController::class, 'beritaAcaraIndex'])->name('survei.ba.index');
Route::post('/berita-acara/tambah', [SurveiController::class, 'beritaAcaraStore'])->name('survei.ba.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

require __DIR__.'/auth.php';
