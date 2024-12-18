<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\UsersController;
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

// Route::middleware(['auth', 'superadmin'])->group(function () {
// });
Route::get('/gallery', [PostsController::class, 'index'])->name('gallery.index');
Route::get('/tambah', [PostsController::class, 'create'])->name('gallery.create');
Route::post('/tambah/simpan', [PostsController::class, 'store'])->name('gallery.store');
Route::get('/gallery/edit/{id}', [PostsController::class, 'edit'])->name('gallery.edit');
Route::post('/gallery/edit/{id}', [PostsController::class, 'update'])->name('gallery.update');
Route::delete('/gallery/{id}', [PostsController::class, 'destroy'])->name('gallery.destroy');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])->name('buku');

});

Route::get('/index', [UsersController::class, 'index'])->name('user.index');
Route::get('/index/edit/{id}', [UsersController::class, 'edit'])->name('user.edit');
Route::post('/index/update/{id}', [UsersController::class, 'update'])->name('user.update');
Route::get('/index/{id}', [UsersController::class, 'destroy'])->name('user.destroy');


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

Route::get('/send-email', [SendEmailController::class, 'index'])->name('kirim-email');
Route::post('/post-email', [SendEmailController::class,'store'])->name('post-email');

Route::get('/registerwithemail', [SendEmailController::class, 'index1'])->name('regiswithmail');

