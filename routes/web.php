<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SeminarController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/seminar/store', [SeminarController::class, 'store'])->name('seminar.store');

Route::get('/seminars', [SeminarController::class, 'index'])->name('seminars.index');
