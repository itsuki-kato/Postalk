<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDmApply extends Model
{
    // define favorite_type
    use HasFactory;

    protected $table = 't_user_dm_apply';

    protected $fillable = [
        'user_id',
        'apply_user_id',
        'apply_status',
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
     * getApplyUser(申請されたユーザー)
     *
     * @return User $User
     */
    public function applyUser()
    {
        return $this->belongsTo('App\Models\User', 'apply_user_id');
    }
}
