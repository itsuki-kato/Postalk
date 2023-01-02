<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserFavoritePost>
 */
class UserFavoritePostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 30),
            'favorite_user_id' => rand(1, 30),
            'post_id' => Post::factory(),
            'favorite_type' => 1
        ];
    }
}
