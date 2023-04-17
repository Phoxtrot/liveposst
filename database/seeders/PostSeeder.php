<?php

namespace Database\Seeders;

use App\Models\Post;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        $posts = Post::factory(3)->untitled()->create();
        $this->enableForeignKey();
    }
}
