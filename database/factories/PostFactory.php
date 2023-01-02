<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
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
            'category_id' => rand(1, 20),
            'post_title' => fake()->sentence(1, 3),
            'post_text' => fake()->realText(200, 2),
            'post_img_url' => '1669393957ルギア2.png'
        ];
    }
}
