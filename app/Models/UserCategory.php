<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    use HasFactory;

    // table名
    protected $table = 't_user_category';

    // 参照するカラムを定義
    protected $fillable = [
        'user_id',
        'category_id',
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
     * getCategory
     *
     * @return Category $Category
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'category_id');
    }
}
