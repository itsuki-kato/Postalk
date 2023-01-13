<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\PostController;
use App\Http\Controllers\Front\UserFollowController;
use App\Http\Controllers\Front\MypageController;
use App\Http\Controllers\Front\UserNotifyController;
use App\Http\Controllers\Front\SearchController;

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

Route::group(['middleware' => 'auth'], function () {
    // マイページ関連
    Route::get('/',                      [MypageController::class, 'profileIndex'])        ->name('mypage.profileIndex');      // プロフィール表示
    Route::post('/update_profile',       [MypageController::class, 'update_profile']);                                         //プロフィール更新
    Route::get('/user_category_list',    [MypageController::class, 'userCategoryList'])    ->name('mypage.userCategoryList');  // ユーザーカテゴリ表示
    Route::post('/update_user_category', [MypageController::class, 'updateUserCategory'])  ->name('mypage.updateUserCategory');  // ユーザーカテゴリ表示
    Route::get('/favorite_post_list',    [MypageController::class, 'favoritePostList'])    ->name('mypage.favoritePostList');  // お気に入り投稿一覧
    Route::get('/follow_list',           [MypageController::class, 'followList'])          ->name('mypage.followList');        // フォローユーザー一覧
    Route::get('/followerList',          [MypageController::class, 'followerList'])        ->name('mypage.followerList');      // フォロワーユーザー一覧
    Route::get('/dmList',                [MypageController::class, 'dmList'])              ->name('mypage.dmList');            // DM一覧

    // フォロー関連
    Route::post('/apply_follow',  [UserFollowController::class, 'apply']) ->name('userFollow.apply');  // フォロー申請
    Route::post('/permit_follow', [UserFollowController::class, 'permit'])->name('userFollow.permit'); // フォロー申請許可
    Route::post('/delete_follow', [UserFollowController::class, 'delete'])->name('userFollow.delete'); // フォロー解除

    // 投稿関連
    Route::get('/post/list',           [PostController::class, 'list'])     ->name('post.list');      // 一覧表示
    Route::get('/post',                [PostController::class, 'index'])    ->name('post.index');     // 入力画面
    Route::get('/post/{post_id}/edit', [PostController::class, 'editIndex'])->name('post.editIndex'); // 編集画面
    Route::post('/post/store_post',    [PostController::class, 'store'])    ->name('post.store');     // 新規作成or編集処理
    Route::post('/post/favorite',      [PostController::class, 'favorite']) ->name('post.favorite');  // 投稿お気に入り登録

    // 通知画面
    Route::get('/notify_unread_list', [UserNotifyController::class, 'unReadList'])->name('notify.unreadList'); // 通知一覧表示
    Route::get('/notify_read_list', [UserNotifyController::class, 'readList'])->name('notify.readList'); // 通知一覧表示
    Route::post('/notify_read', [UserNotifyController::class, 'read'])->name('notify.read'); // 既読処理

    // 検索関連
    Route::get('/search', [SearchController::class, 'index'])->name('search.index'); // 検索画面

    // 他ユーザー関連
    Route::get('/other_user', [UserController::class, 'index'])->name('user.index'); // 他ユーザー画面
});
