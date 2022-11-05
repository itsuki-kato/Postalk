<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'm_category';

    /**
     * getUserCategories
     *
     * @return UserCategory[] $UserCategories
     */
    public function userCategories()
    {
        return $this->hasMany('App\Models\UserCategory', 'category_id', 'category_id');
    }

    /**
     * getPosts
     *
     * @return Post[] $Posts
     */
    public function Posts()
    {
        return $this->hasMany('App\Models\Post', 'category_id', 'category_id');
    }
}
