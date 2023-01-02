<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\UserCategory;
use App\Models\Post;
use App\Models\UserFavoritePost;
use App\Models\UserFollow;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(20)->create();
        UserCategory::factory(5)->create();
        Post::factory(20)->create();
        UserFavoritePost::factory(100)->create();
        UserFollow::factory(100)->create();
    }
}
