<?php

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
