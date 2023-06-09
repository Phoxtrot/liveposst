<?php

namespace Database\Seeders;

use App\Models\Comment;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    use TruncateTable, DisableForeignKeys;
    public function run()
    {
        $this->disableForeignKey();
        $this->truncate('comments');
        $comments = Comment::factory(3)->create();
        $this->enableForeignKey();
    }
}
