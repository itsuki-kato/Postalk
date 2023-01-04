<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotify extends Model
{
    const UNREAD = 0; // 未読
    const READ   = 1; // 既読

    use HasFactory;

    protected $table = 't_user_notify';

    protected $fillable = [
        'user_id',
        'favorite_post_id',
        'follow_id',
        'dm_history_id',
        'system_info_id'
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
}
