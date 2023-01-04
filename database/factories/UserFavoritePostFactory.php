<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

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
            'user_id' => rand(1, 20),
            'favorite_user_id' => rand(1, 20),
            'post_id' => rand(1, 20),
            'favorite_type' => 1
        ];
    }
}
