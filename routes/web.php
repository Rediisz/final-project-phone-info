<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsPageController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\MobileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\MobilePublicController;
use App\Http\Controllers\NewsPublicController;
use App\Http\Controllers\CommentController;

Route::get('/', [HomeController::class, 'index'])->name('home');
require __DIR__.'/admin.php';
require __DIR__.'/user.php'; 


Route::get('/news', [NewsPageController::class, 'index'])->name('news');
/* Route::get('/news/{news}', [NewsPageController::class, 'show'])->name('news.show'); */
Route::get('/compare', [CompareController::class, 'index'])->name('compare');
Route::get('/api/mobiles/search', [CompareController::class, 'search'])->name('mobiles.search');
Route::get('/search', [HomeController::class, 'search'])->name('search');


Route::get('/mobile/{id}', [MobilePublicController::class, 'show'])->name('mobile.show');
Route::get('/news/{id}', [NewsPublicController::class, 'show'])->name('news.show');

Route::middleware('auth')->post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::middleware('auth')->delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::get('/comments/more', [CommentController::class, 'more'])->name('comments.more'); // โหลดเพิ่ม

