<?php

namespace App\Models;

use App\Models\UserFollow;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // table
    protected $table = 't_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'user_id',
        'user_name',
        'password',
        'sex',
        'birth',
        'pf_img_url',
        'bg_img_url',
        'intro',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * getUserCategories
     *
     * @return UserCategory[] $UserCategories
     */
    public function userCategories()
    {
        return $this->hasMany('App\Models\UserCategory', 'user_id');
    }

    /**
     * getPosts
     *
     * @return Post[] $Posts
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'user_id');
    }

    /**
     * getFollowUsers
     * NOTE:自身がフォローしているユーザー
     *
     * @return UserFollow[]
     */
    public function userFollows()
    {
        return $this->hasMany('App\Models\UserFollow', 'user_id');
    }

    /**
     * getFollowerUsers
     * NOTE：自身がフォローされているユーザー(フォロワー)
     *
     * @return UserFollow[]
     */
    public function userFollowers()
    {
        return $this->hasMany('App\Models\UserFollow', 'follow_user_id');
    }

    /**
     * フォローステータスを返します。
     * NOTE：フロント側の表示切り替えで使用する想定
     *
     * @param int $user_id
     * @param int $follow_user_id
     * @return int|null
     */
    public function getFollowStatus($user_id, $follow_user_id)
    {
        $UserFollow = UserFollow::where([
            ['user_id', '=', $user_id],
            ['follow_user_id', '=', $follow_user_id]
        ])->first();

        if(is_null($UserFollow))
        {
            return null; // フォローしていない場合はnullを返す
        }
        elseif($UserFollow->follow_status == UserFollow::FOLLOW_APPLY)
        {
            return UserFollow::FOLLOW_APPLY; // フォロー申請している場合は0を返す
        }
        elseif($UserFollow->follow_status == UserFollow::FOLLOW_PERMIT)
        {
            return UserFollow::FOLLOW_PERMIT; // フォロー許可している場合は1を返す
        }
        else
        {
            // Nothing
        }
    }
}
