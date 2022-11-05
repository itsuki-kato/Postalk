<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    use HasFactory;

    protected $table = 't_user_category';

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
