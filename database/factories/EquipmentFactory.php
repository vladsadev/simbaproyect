<?php

namespace Database\Factories;

use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
//            'equipment_type_id' => EquipmentType::factory(),
            'code' => fake()->randomElement(["EXC-0" . rand(1, 999), "CAM-0" . rand(1, 999)]),
            'brand' => fake()->randomElement(['Caterpillar', 'Epiroc', 'Komatsu']),
            'model' => fake()->randomElement(['S7', 'XT200', 'JJ300']),
            'year' => rand(2000, 2025),
            'status' => fake()->randomElement(['active', 'maintenance', 'inactive']),
            'location' => fake()->randomElement(['La Paz', 'Sucre', 'Puno'])
        ];
    }
}
