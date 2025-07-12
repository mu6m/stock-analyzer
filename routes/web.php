<?php

use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StockController::class, 'index'])->name('stocks.index');
Route::get('/stock/{stock}', [StockController::class, 'show'])->name('stocks.show');
Route::get('/stock/{stock}/dividends', [StockController::class, 'dividends'])->name('stocks.dividends');
Route::get('/stock/{stock}/news', [StockController::class, 'news'])->name('stocks.news');
Route::get('/stock/{stock}/news/{news}', [StockController::class, 'showNews'])->name('stocks.news.show');
Route::get('/stock/{stock}/actions', [StockController::class, 'actions'])->name('stocks.actions');
Route::get('/stock/{stock}/meetings', [StockController::class, 'meetings'])->name('stocks.meetings');
Route::get('/stock/{stock}/sessions', [StockController::class, 'sessions'])->name('stocks.sessions');