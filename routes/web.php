<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/generatePrivateKey', [DashboardController::class, 'generatePrivateKey'])->name('generatePrivateKey');
Route::post('/generatePublicKey', [DashboardController::class, 'generatePublicKey'])->name('generatePublicKey');
Route::post('/encrypt', [DashboardController::class, 'encrypt'])->name('encrypt');
Route::post('/decrypt', [DashboardController::class, 'decrypt'])->name('decrypt');
