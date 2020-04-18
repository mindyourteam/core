<?php

namespace Mindyourteam\Core\Seeds;

use Illuminate\Database\Seeder;
use Symfony\Component\Yaml\Yaml;
use Mindyourteam\Core\Models\Blueprint;

class BlueprintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = __DIR__ . '/../../database/seeds/blueprints-en.yaml';
        $seeds = Yaml::parseFile($path);
        foreach ($seeds as $record) {
            $this->info($record['body']);
            Blueprint::create($record);
        }
    }
}