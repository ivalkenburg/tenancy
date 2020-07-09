<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        Artisan::call('app:update-permissions');
    }
}
