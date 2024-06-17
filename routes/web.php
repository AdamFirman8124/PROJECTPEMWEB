<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\SeminarMaterialsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SpeakerController;

// Rute untuk halaman utama
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rute untuk autentikasi
Auth::routes();

// Rute untuk halaman beranda
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rute untuk menyimpan seminar
Route::post('/seminar', [SeminarController::class, 'store'])->name('seminar.store');

// Rute untuk menampilkan semua seminar
Route::get('/seminar', [SeminarController::class, 'index'])->name('seminar.index');

// Rute untuk menampilkan detail seminar
Route::get('/seminars/{id}', [SeminarController::class, 'show'])->name('seminar.detail');

// Rute untuk menampilkan semua materi seminar
Route::get('/seminar_materials', [SeminarMaterialsController::class, 'index'])->name('seminar_materials.index');

// Rute untuk membuat materi seminar
Route::get('/seminar_materials/create', [SeminarMaterialsController::class, 'create'])->name('seminar_materials.create');

// Rute untuk menyimpan materi seminar
Route::post('/seminar_materials', [SeminarMaterialsController::class, 'store'])->name('seminar_materials.store');

// Rute untuk menampilkan detail materi seminar
Route::get('/seminar_materials/{seminar_material}', [SeminarMaterialsController::class, 'show'])->name('seminar_materials.show');

// Rute untuk mengedit materi seminar
Route::get('/seminar_materials/{seminar_material}/edit', [SeminarMaterialsController::class, 'edit'])->name('seminar_materials.edit');

// Rute untuk memperbarui materi seminar
Route::put('/seminar_materials/{seminar_material}', [SeminarMaterialsController::class, 'update'])->name('seminar_materials.update');

// Rute untuk menghapus materi seminar
Route::delete('/seminar_materials/{seminar_material}', [SeminarMaterialsController::class, 'destroy'])->name('seminar_materials.destroy');

// Rute untuk rekap seminar
Route::get('/seminar/rekap', [SeminarController::class, 'rekap'])->name('seminar.rekap');

// Rute untuk pendaftaran seminar
Route::post('/seminar/register', [SeminarController::class, 'register'])->name('seminar.register');

// Rute untuk mengedit seminar
Route::get('/seminar/{seminar}/edit', [SeminarController::class, 'edit'])->name('seminar.edit');

// Rute untuk memperbarui seminar
Route::put('/seminar/{seminar}', [SeminarController::class, 'update'])->name('seminar.update');

// Rute untuk menghapus seminar
Route::delete('/seminar/{seminar}', [SeminarController::class, 'destroy'])->name('seminar.destroy');

// Rute untuk rekap peserta seminar
Route::get('/seminar/rekap-peserta', [SeminarController::class, 'rekapPeserta'])->name('seminar.rekap-peserta');

// Rute alternatif untuk rekap seminar
Route::get('/seminar/rekap', [SeminarController::class, 'rekap'])->name('seminar.rekap');

// Rute untuk menghapus pengguna
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// Rute untuk menampilkan semua pengguna
Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Rute untuk membuat pendaftaran
Route::get('/daftar', [RegistrationController::class, 'create'])->name('daftar.create');

// Rute untuk menyimpan pendaftaran
Route::post('/daftar', [RegistrationController::class, 'store'])->name('registrations.store');

// Rute untuk menampilkan semua pendaftaran
Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');

// Rute untuk menghapus pendaftaran
Route::delete('/registrations/{id}', [RegistrationController::class, 'destroy'])->name('registrations.destroy');

// Rute untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute untuk membuat seminar
Route::resource('seminars', SeminarController::class);

// Rute untuk sertifikat seminar
Route::get('/seminar/certificate', [SeminarController::class, 'certificate'])->name('seminar.certificate');

// Rute untuk mengunggah sertifikat seminar
Route::post('/seminars/{seminar}/uploadCertificate', [SeminarController::class, 'uploadCertificate'])->name('seminar.uploadCertificate');

// Rute untuk menghapus seminar
Route::delete('/seminars/{seminar}', [SeminarController::class, 'destroy'])->name('seminars.destroy');

// Rute untuk memperbarui sertifikat seminar
Route::put('/seminars/certificate/{template}', [SeminarController::class, 'updateCertificate'])->name('seminar.updateCertificate');

// Rute untuk menampilkan sertifikat seminar
Route::get('/seminar/certificates', [SeminarController::class, 'showCertificates'])->name('seminar.showCertificates');

// Rute untuk membuat seminar
Route::get('/seminar/create', [SeminarController::class, 'create'])->name('seminar.create');

// Rute untuk membuat pendaftaran
Route::get('/registrations/create', [RegistrationController::class, 'create'])->name('registrations.create');

// Rute untuk edit data peserta seminar
Route::get('/registrations/{id}/edit', [RegistrationController::class, 'edit'])->name('registrations.edit');
Route::put('/registrations/{id}', [RegistrationController::class, 'update'])->name('registrations.update');

// Rute untuk menampilkan detail sertifikat seminar
Route::get('/seminars/{seminar}/certificate-detail', [SeminarController::class, 'showCertificateDetail'])->name('seminar.certificate-detail');

// Rute untuk menampilkan form edit seminar
Route::get('/seminars/{seminar}/edit', [SeminarController::class, 'edit'])->name('seminars.edit');

// Rute untuk mengupdate data seminar
Route::put('/seminars/{seminar}', [SeminarController::class, 'update'])->name('seminars.update');

// Rute untuk menampilkan detail sertifikat seminar
Route::get('/seminars/{id}/certificate-detail', [SeminarController::class, 'showCertificateDetail'])->name('seminar.certificate-detail');

// Rute untuk mengunduh sertifikat seminar
Route::get('/seminars/{seminar}/download-certificate', [SeminarController::class, 'downloadCertificate'])->name('seminar.download-certificate');

// Rute untuk mengedit role pengguna
Route::get('/users/{id}/edit-role', [UserController::class, 'editRole'])->name('users.edit-role');
Route::put('/users/{id}/update-role', [UserController::class, 'updateRole'])->name('users.update-role');
