<?php

use App\Http\Controllers\DownloadSertifController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\SeminarMaterialsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LPController;
use App\Http\Controllers\HomeUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\Auth\RegisterController;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('export-users', [UserController::class, 'export'])->name('users.export');
Route::get('/users/download-pdf', [UserController::class, 'downloadPdf'])->name('users.download-pdf');

// Rute untuk halaman utama
// Route::get('/', function () {
//     return view('index');
// })->name('welcome');
Route::get('/', [LPController::class, 'landingpage'])->name('landingpage');
Route::get('/home-user', [HomeUserController::class, 'index'])->name('homeuser');
Route::get('/daftar-seminar/{seminar_id}', [HomeUserController::class, 'daftarseminar'])->name('daftarseminar');
Route::get('/showseminar/{id}', [HomeUserController::class, 'show'])->name('detailseminaruser');
Route::post('/daftarnya', [HomeUserController::class, 'pendaftaranseminar'])->name('pendaftaranseminar');

Route::post('register', [RegisterController::class, 'register'])->middleware('disable-session');


// Rute untuk autentikasi
Auth::routes();

Route::prefix('admin')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('', [AdminController::class, 'index'])->name('admin_dashboard');
        Route::get('/admin-dashboard/{filter}', [AdminController::class, 'filter'])->name('admin_dashboard_filter');
        // Rute untuk membuat seminar
        Route::get('/tambah-seminar', [AdminController::class, 'create'])->name('tambahseminar');
        Route::post('/tambah', [AdminController::class, 'store'])->name('admin.tambahseminar');
        Route::get('/detail-seminar/{id}', [AdminController::class, 'show'])->name('detailseminar');
    });
    Route::prefix('rekap-seminar')->group(function () {
        Route::get('', [AdminController::class, 'rekap'])->name('admin.rekap');
        // Rute untuk mengedit seminar
        Route::get('/seminar/{seminar}/edit', [AdminController::class, 'edit'])->name('admin.seminar.edit');
        // Rute untuk memperbarui seminar
        Route::put('/seminar/{seminar}', [AdminController::class, 'update'])->name('admin.seminar.update');
        Route::delete('/seminars/{seminar}', [AdminController::class, 'hapusseminar'])->name('seminars.destroy');
    });
    Route::prefix('rekap-peserta')->group(function () {
        Route::get('', [AdminController::class, 'datapeserta'])->name('rekap_peserta');
        Route::get('/{id}/edit', [AdminController::class, 'editpeserta'])->name('admin.registrations.edit');
        Route::delete('/hapus/{id}', [AdminController::class, 'hapuspeserta'])->name('registrations.destroy');
        Route::put('/registrations/{id}', [AdminController::class, 'updatepeserta'])->name('admin.registrations.update');
        Route::get('/registrations/export', [RegistrationController::class, 'export'])->name('registrations.export');
        Route::get('/registrations/export-pdf', [RegistrationController::class, 'exportPdf'])->name('registrations.exportPdf');
    });

    Route::prefix('rekap-pengguna')->group(function () {
        Route::get('', [AdminController::class, 'rekapPeserta'])->name('data_pengguna');
    });
    Route::prefix('tambah-materi')->group(function () {
        //Rute untuk tambah materi
        Route::get('', [AdminController::class, 'tambahMateri'])->name('admin.tambahMateri');
        Route::post('/admin/simpan-materi', [AdminController::class, 'simpanMateri'])->name('admin.simpanMateri');
    });
    Route::prefix('upload-sertifikat')->group(function () {
        // Rute untuk sertifikat seminar
        Route::get('', [AdminController::class, 'certificate'])->name('admin.certificate');
        // Rute untuk mengunggah sertifikat seminar
        Route::post('/seminars/{seminar}/uploadCertificate', [AdminController::class, 'uploadCertificate'])->name('admin.uploadCertificate');
        Route::put('/seminars/certificate/{template}', [AdminController::class, 'updateCertificate'])->name('seminar.updateCertificate');
    });
    //Rute untuk men download sertifikat
    Route::get('certificate/export', [AdminController::class, 'export']);

    //Rute untuk tambah pembicara
    Route::get('/tambah-pembicara', [AdminController::class, 'tambahPembicara'])->name('admin.tambahPembicara');
    Route::post('/simpan-pembicara', [AdminController::class, 'simpanPembicara'])->name('admin.simpanPembicara');

    Route::get('/datapembicara', [AdminController::class, 'dataPembicara'])->name('admin.datapembicara');
    Route::delete('/pembicara/{id}', [AdminController::class, 'deletePembicara'])->name('admin.deletePembicara');
    Route::get('/pembicara/{id}/edit', [AdminController::class, 'editPembicara'])->name('admin.editPembicara');
    Route::put('/pembicara/{id}', [AdminController::class, 'updatePembicara'])->name('admin.updatePembicara');
    Route::get('/exportPembicara', [AdminController::class, 'exportPembicara'])->name('admin.exportPembicara');


    //Rute untuk export data pembicara
    // Route::get('pembicara/export', [AdminController::class, 'export'])->name('admin.exportPembicara');



    // Rute untuk export seminar
    Route::get('/export-seminar', [AdminController::class, 'exportSeminar'])->name('admin.exportSeminar');

    //Rute untuk export materi
    Route::get('/export-materi', [AdminController::class, 'exportMateri'])->name('admin.exportMateri');

    //Rute untuk export sertifikat
    Route::get('/export-certificate', [AdminController::class, 'exportCertificate'])->name('admin.exportCertificate');
});
// Rute untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute untuk mengedit role pengguna
Route::get('/users/{id}/edit-role', [UserController::class, 'editRole'])->name('users.edit-role');
Route::put('/users/{id}/update-role', [UserController::class, 'updateRole'])->name('users.update-role');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/seminar/store', 'SeminarController@store')->name('seminar.store');

// Rute untuk tambah pembicara
Route::get('/admin/tambahpembicara', 'AdminController@index');

Route::get('/download-certificate/{seminarId}', [DownloadSertifController::class, 'downloadCertificate'])
    ->name('downloadCertificate');

Route::get('/refresh', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    return 'Done bg';
});
