<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdreControlleur;
Route::get('/', [OrdreControlleur::class, 'index']);
Route::post('/store', [OrdreControlleur::class, 'store'])->name('store');
