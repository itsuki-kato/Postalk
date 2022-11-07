<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // table名
    protected $table = 'm_category';

    // 参照するカラムを定義
    protected $fillable = [
        'category_id',
        'category_name',
        'create_at',
        'update_at'
    ];

    // 参照しないカラムを定義
    protected $gurded = [];

    // 主キーのautoincrementを無効化
    public $incrementing = false;

    // timestampの
    public $timestamps = false;

}
