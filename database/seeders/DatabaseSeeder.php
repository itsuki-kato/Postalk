<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\UserCategory;
use App\Models\Post;
use App\Models\UserFavoritePost;
use App\Models\UserFollow;
use App\Models\User;
use App\Models\UserNotify;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(20)->create();
        Category::factory(20)->create();
        UserCategory::factory(100)->create();
        Post::factory(100)->create();
        UserFavoritePost::factory(100)->create();
        UserFollow::factory(200)->create();
        // UserNotify::factory(20)->create();
    }
}
