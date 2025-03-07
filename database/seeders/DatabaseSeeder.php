<?php

namespace Database\Seeders;

use App\Models\Group;
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

        $admin = User::factory()->create([
            'firstname' => 'Jean-Marc',
            'lastname' => 'Strauven',
            'email' => 'jms@grazulex.be',
        ]);

        Group::factory()->create([
            'name' => 'Admins',
            'description' => 'Administrators group',
            'user_id' => $admin->id,
        ]);
    }
}
