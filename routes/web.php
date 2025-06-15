<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CommentController; // Pastikan ini ada

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute untuk Landing Page (Root URL)
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk Daftar Berita Publik (Hanya Lihat)
Route::get('/news-public', [NewsController::class, 'publicIndex'])->name('news.public_index');

// Rute Resource untuk News (CRUD Lengkap)
Route::resource('news', NewsController::class);

// Rute Resource untuk Comments (CRUD)
// Perhatikan bahwa 'edit' tidak dikecualikan di sini, jadi rute GET untuk comments/{comment}/edit akan dibuat.
Route::resource('comments', CommentController::class)->except(['create', 'show']);

// Anda dapat menambahkan rute lain di sini
