<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavoritePost extends Model
{
    // define favorite_type
    const TYPE_LIKE = 1;
    const TYPE_SUPER_LIKE = 2;

    use HasFactory;

    protected $table = 't_user_favorite_post';

    protected $primaryKey = [
        'user_id', 
        'favorite_user_id', 
        'post_id'
    ];

    protected $fillable = [
        'user_id',
        'favorite_user_id',
        'post_id',
        'favorite_type',
        'create_at',
        'update_at'
    ];

    // 参照しないカラムを定義
    protected $gurded = [];

    // 主キーのautoincrementを無効化
    public $incrementing = false;

    // timestampの
    public $timestamps = false;

    /**
     * getUser
     *
     * @return User $User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }

    /**
     * getPost
     *
     * @return Post $Post
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'post_id');
    }

    /**
     * TODO:動作確認
     * isMyFavorite
     * 
     * @param [string] $user_id
     * @return bool
     */
    public function isMyFavorite($user_id)
    {
        if($this->favorite_user_id == $user_id)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
