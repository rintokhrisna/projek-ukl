<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Import controller
use App\Http\Controllers\NewsController; // <--- PASTIKAN INI ADA



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing'); // Mengarahkan root URL ke view 'landing.blade.php'
})->name('landing');

// Resource route untuk UserController
Route::resource('users', UserController::class);
Route::resource('news', NewsController::class);

// Anda bisa melihat daftar route yang dibuat dengan: php artisan route:list    