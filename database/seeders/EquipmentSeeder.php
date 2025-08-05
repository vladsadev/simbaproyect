<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // Crear los 3 tipos de equipos específicos
        $excavadora = EquipmentType::factory()->excavadora()->create();
        $camion = EquipmentType::factory()->camion()->create();
        $perforadora = EquipmentType::factory()->perforadora()->create();

        // Crear equipos con especificaciones realistas por tipo

        // 5 Excavadoras con especificaciones de excavadora
        Equipment::factory(3)
            ->excavadora()
            ->create(['equipment_type_id' => $excavadora->id]);

        // 8 Camiones con especificaciones de camión
        Equipment::factory(2)
            ->camion()
            ->create(['equipment_type_id' => $camion->id]);

        // 3 Perforadoras con especificaciones de perforadora
        Equipment::factory(3)
            ->perforadora()
            ->create(['equipment_type_id' => $perforadora->id]);
    }
}
