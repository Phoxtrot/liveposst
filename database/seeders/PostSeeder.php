<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Database\Factories\CommentFactory;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\Helpers\generateRandomModelId;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    use TruncateTable, DisableForeignKeys;
    public function run(): void
    {
        $this->disableForeignKey();
        $this->truncate('posts');
        $posts = Post::factory(200)
        // ->has(Comment::Factory(3),'comments')
        ->create();
        $posts->each(function (Post $post){
            $post->users()->sync([generateRandomModelId::generateRandomModelId(User::class)]);
        });
        $this->enableForeignKey();
    }
}
