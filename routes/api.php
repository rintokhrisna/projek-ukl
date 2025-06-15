<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsApiController; // Impor NewsApiController
use App\Http\Controllers\Api\CommentApiController;// Impor CommentApiController

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute API untuk aplikasi Anda. Rute-rute ini
| dimuat oleh RouteServiceProvider dan semuanya akan ditetapkan ke
| grup middleware "api". Jadikan sesuatu yang hebat!
|
*/


// --- Rute untuk API Berita (News) --- 
// Mendapatkan semua berita (GET /api/news)
Route::get('/news', [NewsApiController::class, 'index']);
// Mendapatkan detail berita tertentu (GET /api/news/{id})
Route::get('/news/{id}', [NewsApiController::class, 'show']);


// Rute untuk CRUD berita yang memerlukan autentikasi
// Middleware 'auth:sanctum' memastikan hanya pengguna terautentikasi yang bisa mengaksesnya
Route::post('/news', [NewsApiController::class, 'store'])->middleware('auth:sanctum');
Route::put('/news/{news}', [NewsApiController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/news/{news}', [NewsApiController::class, 'destroy'])->middleware('auth:sanctum');


// --- Rute untuk API Komentar (Comment) ---
// Mendapatkan semua komentar untuk berita tertentu (GET /api/news/{id}/comments)
// Ini adalah endpoint yang bagus untuk aplikasi frontend yang ingin menampilkan komentar.
Route::get('/news/{news}/comments', [CommentApiController::class, 'index']);
// Membuat komentar baru (POST /api/comments)
// Karena komentar bisa dari tamu, kita tidak secara otomatis menerapkan 'auth:sanctum' di sini.
// Anda bisa menambahkannya jika ingin hanya pengguna terautentikasi yang bisa berkomentar.
Route::post('/comments', [CommentApiController::class, 'store']);
