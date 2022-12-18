<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // table名
    protected $table = 't_user_post';

    // 参照するカラムを定義
    protected $fillable = [
        'user_id',
        'category_id',
        'post_id',
        'post_title',
        'post_text',
        'post_img_url',
    ];

    // 参照しないカラムを定義
    protected $gurded = [];

    /**
     * getUser
     *
     * @return User $User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * getCategory
     *
     * @return Category $Category
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    /**
     * getUserFavoritePost
     *
     * @return UserFavoritePost[] $UserFavoritePosts
     */
    public function userFavoritePosts()
    {
        return $this->hasMany('App\Models\UserFavoritePost', 'post_id');
    }

    /**
     * ログインユーザーが投稿をお気に入り登録しているかどうか判断します。
     * NOTE:主にフロント側のお気に入りボタンの制御に使用します。
     *
     * @param string $user_id
     * @return bool
     */
    public function isMyFavorite($user_id)
    {
        $UserFavoritePost = 
            UserFavoritePost::where([
                ['favorite_user_id', $user_id], 
                ['post_id', $this->id]
            ])->first();

        if(is_null($UserFavoritePost)) {
            // お気に入り登録していない場合
            return false;
        } else {
            // お気に入り登録している場合
            return true;
        }
    }
}
