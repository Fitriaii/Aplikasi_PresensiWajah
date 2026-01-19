<?php

use App\Http\Controllers\Admin\AttendancesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ParticipantsController;
use App\Http\Controllers\PresensiPesertaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PresensiPesertaController::class, 'index'])->name('landing.page');
Route::get('training-page/{id}', [PresensiPesertaController::class, 'train'])->name('train.page');
Route::post('/peserta/face-check',[PresensiPesertaController::class, 'check'])->name('face.check');
Route::post('/peserta/{id}/face-register', [PresensiPesertaController::class, 'faceRegister'])->name('peserta.register');
Route::get('/peserta/presensi/{id}', [PresensiPesertaController::class, 'showCaptureForm'])->name('presensi.kamera');

Route::get('/scan-qr-code/{id}', [PresensiPesertaController::class, 'scanQR'])->name('scan.qr.code.page');
Route::post('/presensi/qr', [PresensiPesertaController::class, 'submitQR'])->name('presensi.qr.attendance');
Route::post('/presensi/face', [PresensiPesertaController::class, 'faceAttendance'])->name('presensi.face.attendance');

Route::get('/admin', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('peserta', ParticipantsController::class);

    Route::get('presensi', [AttendancesController::class, 'settingPage'])->name('presensi.setting.page');
    Route::post('presensi-setting', [AttendancesController::class, 'setting'])->name('presensi.setting');
    Route::get('/admin/presensi/qrcode', [AttendancesController::class, 'qrPage'])->name('presensi.qr.page');
    Route::post('/qrcode/generate', [AttendancesController::class, 'qrCode'])->name('qrcode.generate');
    Route::post('/admin/presensi/qrcode/regenerate', [AttendancesController::class, 'regenerateQRCode'])->name('presensi.qr.regenerate');
    Route::post('/QR-form/{token}', [AttendancesController::class, 'qrForm'])->name('qr.from');
    Route::post('/presensi-nonaktif', [AttendancesController::class, 'nonaktif'])->name('presensi.nonaktif');

    Route::get('/presensi/manual', [AttendancesController::class, 'create'])->name('presensi.manual');
    Route::post('/presensi-manual', [AttendancesController::class, 'store'])->name('presensi.manual.store');
    // Route::get('/presensi', [AttendancesController::class, 'index'])->name('presensi.index');


});

require __DIR__.'/auth.php';
