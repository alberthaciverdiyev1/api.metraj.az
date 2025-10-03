<?php

namespace Modules\Ad\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Ad\Database\Factories\AdFactory;

class AdDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 sample ads for testing
        AdFactory::new()->count(10)->create();
        
        $this->command->info('Sample ads created successfully!');
    }
}
