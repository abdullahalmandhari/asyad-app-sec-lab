<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */
		// in DatabaseSeeder.php (or tinker once)
\App\Models\User::factory()->create([
    'email' => 'md5@example.com',
    'password' => md5('secret123'),      // MD5 for the vulnerable demo
]);

\App\Models\User::factory()->create([
    'email' => 'bcrypt@example.com',
    'password' => bcrypt('secret123'),   // bcrypt for the secure demo
]);


		 $this->call(ShipmentSeeder::class);
		 
    }
}
