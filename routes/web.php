<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsPageController;

Route::get('/', [HomeController::class, 'index'])->name('home');
require __DIR__.'/admin.php';

Route::get('/news', [NewsPageController::class, 'index'])->name('news');
Route::get('/news/{news}', [NewsPageController::class, 'show'])->name('news.show');

