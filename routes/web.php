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

// Auth
Auth::routes();

// Post
Route::get('/post/list', [PostController::class, 'list'])->name('post.list'); // 一覧表示
Route::get('/post', [PostController::class, 'index'])->name('post.index'); // 入力画面
Route::get('/post/{post_id}/edit', [PostController::class, 'editIndex'])->name('post.editIndex'); // 入力画面
Route::post('/post/store_post', [PostController::class, 'store'])->name('post.store'); // 新規作成or編集
Route::post('/post/favorite', [PostController::class, 'favorite'])->name('post.favorite'); // 投稿お気に入り登録                                        // フォロー解除

Route::group(['middleware' => 'auth'], function () {
    Route::get('/',        function () { return view('user/mypage'); })  ->name('user.mypage');
    Route::get('/profile', function () { return view('user/profile'); }) ->name('user.profile');
    Route::post('/update_profile', [UserController::class, 'update_profile']); //プロフィール更新
});
