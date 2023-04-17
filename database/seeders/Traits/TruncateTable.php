<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

trait TruncateTable
{
    /**
     * Run the database seeds.
     */
    public function truncate($table)
    {
        DB::table("$table")->truncate();
    }
}
