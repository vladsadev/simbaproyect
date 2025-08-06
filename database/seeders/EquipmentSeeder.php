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

        //  Excavadoras con especificaciones de excavadora
        Equipment::factory(4)
            ->excavadora()
            ->create(['equipment_type_id' => $excavadora->id]);

        //  Camiones con especificaciones de camión
        Equipment::factory(2)
            ->camion()
            ->create(['equipment_type_id' => $camion->id]);

        //  Perforadoras con especificaciones de perforadora
        Equipment::factory(4)
            ->perforadora()
            ->create(['equipment_type_id' => $perforadora->id]);
    }
}
