<?php

use Illuminate\Database\Seeder;

use Mindyourteam\Core\Seeds\BlueprintSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BlueprintSeeder::class);
    }
}
