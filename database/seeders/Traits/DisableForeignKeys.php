<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

trait DisableForeignKeys
{
    /**
     * Run the database seeds.
     */
    public function disableForeignKey()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS=0");
    }
    public function enableForeignKey()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS=1");
    }
}
