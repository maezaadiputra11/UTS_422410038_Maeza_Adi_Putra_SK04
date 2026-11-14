<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormatMediaController;
use App\Http\Controllers\KoleksiPitaController;
use App\Http\Controllers\TindakanRestorasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');

// ->parameters() dipakai supaya nama parameter eksplisit & cocok dengan type-hint model
// (hindari singularisasi otomatis, mis. "media" -> "medium", "pita" -> "pitum").
Route::resource('koleksi', KoleksiPitaController::class)
    ->parameters(['koleksi' => 'koleksiPita']);

Route::resource('format-media', FormatMediaController::class)
    ->parameters(['format-media' => 'formatMedia'])
    ->except('show');

Route::resource('tindakan-restorasi', TindakanRestorasiController::class)
    ->parameters(['tindakan-restorasi' => 'tindakanRestorasi'])
    ->except('show');
