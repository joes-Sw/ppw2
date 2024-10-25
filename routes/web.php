<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('restricted', function () {
    return "Anda berusia lebih dari 18 tahun !";
})->middleware('checkage');

Route::get('/about', function () {
    return view('about', [
        'name' => 'example',
        'email' =>'example@gmail.com'
    ]);
});

Route::middleware(['auth', 'superadmin'])->group(function () {
Route::get('/posts', [PostsController::class, 'index']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])->name('buku');

});


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
    Route::get('/logout', 'logout')->name('logout');
    Route::post('/logout',  'logout')->name('logout');
});

