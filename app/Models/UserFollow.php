<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    // define follow_status
    const FOLLOW_APPLY = 0; // フォロー申請中(相手からのフォロー許可待ち)
    const FOLLOW_PERMIT = 1; // フォロー中(相手からのフォロー許可済み)

    use HasFactory;

    protected $table = 't_user_follow';

    protected $fillable = [
        'user_id',
        'follow_user_id',
        'follow_status'
    ];

    // 参照しないカラムを定義
    protected $gurded = [];

    /**
     * getUser(フォロー申請した側)
     *
     * @return User $User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * getFollowUser(フォロー申請された側)
     *
     * @return User $User
     */
    public function followUser()
    {
        return $this->belongsTo('App\Models\User', 'follow_user_id');
    }

    /**
     * ログインユーザーが該当のユーザーをフォローしているかどうか判断します。
     * NOTE:主にフロント側のフォローボタンの制御に使用します。
     *
     * @param string $follow_user_id
     * @return bool
     */
    public function isFollowUser($follow_user_id)
    {
        $UserFollow = 
            UserFavoritePost::where([
                ['follow_user_id', $follow_user_id], 
                ['user_id', $this->user_id]
            ]
        )->first();

        if(is_null($UserFollow)) {
            // フォローしている場合場合
            return false;
        } else {
            // フォローしてない場合
            return true;
        }
    }

    /**
     * ログインユーザーが該当のユーザーにフォローされているかどうか判断します。
     * NOTE:主にフロント側のフォローボタンの制御に使用します。
     *
     * @return bool
     */
    public function isFollowedUser($user_id)
    {
        // TODO:実装
    }
}
