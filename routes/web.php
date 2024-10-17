<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about', [
        'name' => 'example',
        'email' =>'example@gmail.com'
    ]);
});


Route::get('/posts', [PostsController::class, 'index']);

Route::get('/buku', [BukuController::class, 'index'])->name('buku')->middleware('auth');
Route::get('/buku/tambah', [BukuController::class, 'create'])->name('buku.tambah');
Route::post('/buku/simpan', [BukuController::class, 'store'])->name('buku.store');
Route::get('/buku/ubah/{id}', [BukuController::class, 'edit'])->name('buku.edit');
Route::post('/buku/simpan/{id}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{id}', [BukuController::class, 'destroy']);

Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'register')->name('register')->middleware('guest');
    Route::post('/store', 'store')->name('store')->middleware('guest');
    Route::get('/login', 'login')->name('login')->middleware('guest');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/logout', 'logout')->middleware('auth');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});