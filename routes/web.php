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

// UserLogin
Route::get('/login', function () { return view('user/login'); }); // ログイン画面
Route::post('/login', [UserController::class, 'login']);          // ログイン

// UserLogout
Route::get('/logout', [UserController::class, 'logout']); // ログアウト

// UserCreate
Route::get('/create', function () { return view('user/create'); }); // ユーザー登録画面
Route::post('/create', [UserController::class, 'create_user']);     // ユーザー登録

// Top
// TODO：middlewareのauthチェックを有効にする。
Route::group(['middleware => auth'], function () {
    Route::get('/', function () { return view('top'); });
    Route::get('/{user_id}', function () { return view('user/top'); })->name('user.top');        // マイページ画面
    Route::get('/{user_id}/edit', function () { return view('user/edit'); })->name('user.edit'); // プロフィール編集画面
    Route::post('/{user_id}/edit', [UserController::class, 'update_user'])->name('user.edit');   // プロフィール更新
    Route::post('/{user_id}/select_category', [UserController::class, 'select_user_category']);  // カテゴリ選択
});

// Post
Route::get('/post/list', [PostController::class, 'list'])->name('post.list'); // 一覧表示
Route::get('/post', [PostController::class, 'index'])->name('post.index'); // 入力画面
Route::get('/post/{post_id}/edit', [PostController::class, 'editIndex'])->name('post.editIndex'); // 入力画面
Route::post('/post/valid', [PostController::class, 'valid'])->name('post.valid'); // バリデーションと新規作成or編集

