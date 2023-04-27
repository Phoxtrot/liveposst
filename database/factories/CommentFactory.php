<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Helpers\generateRandomModelId;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        return [
            'body'=> [],
            'user_id'=> GenerateRandomModelId::generateRandomModelId(User::class),
            'post_id'=> GenerateRandomModelId::generateRandomModelId(Post::class),
        ];
    }
}
