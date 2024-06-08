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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/seminar', [SeminarController::class, 'store'])->name('seminar.store');

Route::get('/seminar', [SeminarController::class, 'index'])->name('seminar.index');

Route::get('/seminars', [SeminarController::class, 'index'])->name('seminars.index');

Route::get('/seminar/{id}', [SeminarController::class, 'show'])->name('seminar.show');

Route::get('/seminar_materials',[SeminarMaterialsController::class, 'index'])->name('seminar_materials.index');

Route::get('/seminar_materials/create',[SeminarMaterialsController::class, 'create'])->name('seminar_materials.create');

Route::post('/seminar_materials',[SeminarMaterialsController::class, 'store'])->name('seminar_materials.store');

Route::get('/seminar_materials/{seminar_material}',[SeminarMaterialsController::class, 'show'])->name('seminar_materials.show');

Route::get('/seminar_materials/{seminar_material}/edit',[SeminarMaterialsController::class, 'edit'])->name('seminar_materials.edit');

Route::put('/seminar_materials/{seminar_material}',[SeminarMaterialsController::class, 'update'])->name('seminar_materials.update'); 

Route::delete('/seminar_materials/{seminar_material}',[SeminarMaterialsController::class, 'destroy'])->name('seminar_materials.destroy');

Route::get('/seminar/rekap', [SeminarController::class, 'rekap'])->name('seminar.rekap');

Route::post('/seminar/register', [SeminarController::class, 'register'])->name('seminar.register');

Route::get('/seminar/{seminar}/edit', [SeminarController::class, 'edit'])->name('seminar.edit');

Route::put('/seminar/{seminar}', [SeminarController::class, 'update'])->name('seminar.update');

Route::delete('/seminar/{seminar}', [SeminarController::class, 'destroy'])->name('seminar.destroy');

Route::get('/seminars/rekap-peserta', [SeminarController::class, 'rekapPeserta'])->name('seminars.rekap-peserta');

Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/daftar', [RegistrationController::class, 'create'])->name('daftar.create');

Route::post('/daftar', [RegistrationController::class, 'store'])->name('registrations.store');

Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');

Route::delete('/registrations/{id}', [RegistrationController::class, 'destroy'])->name('registrations.destroy');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route for registration form and storing registration
// Route::middleware(['auth'])->group(function () {
//     Route::get('/registrations/create', [RegistrationController::class, 'create'])->name('registrations.create');
//     Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');
// });

// // Route for admin to view registrations
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
// });

Route::get('/seminars/create', [SeminarController::class, 'create'])->name('seminars.create');

Route::get('/seminars/certificate', [SeminarController::class, 'certificate'])->name('seminars.certificate');

Route::post('/seminar/upload-certificate', [SeminarController::class, 'uploadCertificate'])->name('seminar.uploadCertificate');

