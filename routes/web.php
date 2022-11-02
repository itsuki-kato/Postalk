<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\PostController;

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

// login
Route::get('/login', [UserController::class, 'login']);

// Top
// TODO：middlewareのauthチェックを有効にする。
Route::group(['middleware => auth'], function () {
    Route::get('/', function () { return view('top'); });
});

// Post
Route::get('/post', [PostController::class, 'index'])->name('post.index'); // 入力画面
Route::post('/post/valid', [PostController::class, 'valid'])->name('post.valid'); // バリデーションと新規作成or編集
