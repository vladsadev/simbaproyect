<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\EquipmentFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        User::factory()->withPersonalTeam()->create([
            'name' => 'Pepe',
            'email' => 'pepe@pp.com',
            'password' => '1524780032'
        ]);

        User::factory(10)->create();

//        Equipment::factory(25)->create();

        $this->call(EquipmentSeeder::class);

    }
}
