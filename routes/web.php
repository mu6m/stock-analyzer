<?php

use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StockController::class, 'index'])->name('stocks.index');
// Route::get('/stocks/{stock}', [StockController::class, 'show'])->name('stocks.show');