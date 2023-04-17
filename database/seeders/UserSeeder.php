<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    use TruncateTable, DisableForeignKeys;
    public function run()
    {
        $this->disableForeignKey();
        $this->truncate("users");
        \App\Models\User::factory(10)->create();
        $this->enableForeignKey();


    }
}
