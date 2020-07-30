<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // 系統設定
            SystemConfigSeeder::class,
            OperationSeeder::class
        ]);
    }
}
