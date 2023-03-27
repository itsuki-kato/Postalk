<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    // define follow_status
    const FOLLOW_APPLY = 0;  // フォロー申請中(相手からのフォロー許可待ち)
    const FOLLOW_PERMIT = 1; // フォロー許可

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
}
