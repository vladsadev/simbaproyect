<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Inspection;

class InspectionTable extends DataTableComponent
{
    protected $model = Inspection::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
//            Column::make("Id", "id")
//                ->sortable(),
            // Otra columna del equipo - por ejemplo el código
            Column::make("Equipment Code", "equipment.code")
                ->sortable()
                ->searchable(),

            Column::make("Equipment id", 'equipment.code')
                ->sortable(),
            Column::make("User id", "user_id")
                ->sortable(),
            Column::make("Inspection date", "inspection_date")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("Observations", "observations")
                ->sortable(),
            Column::make("Cuchara checked", "cuchara_checked")
                ->sortable(),
            Column::make("Llantas checked", "llantas_checked")
                ->sortable(),
            Column::make("Articulacion checked", "articulacion_checked")
                ->sortable(),
            Column::make("Cilindro checked", "cilindro_checked")
                ->sortable(),
            Column::make("Botellones checked", "botellones_checked")
                ->sortable(),
            Column::make("Zbar checked", "zbar_checked")
                ->sortable(),
            Column::make("Dogbone checked", "dogbone_checked")
                ->sortable(),
            Column::make("Brazo checked", "brazo_checked")
                ->sortable(),
            Column::make("Tablero checked", "tablero_checked")
                ->sortable(),
            Column::make("Extintores checked", "extintores_checked")
                ->sortable(),
            Column::make("Epp complete", "epp_complete")
                ->sortable(),
//            Column::make("Updated at", "updated_at")
//                ->sortable(),
        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        // Es importante incluir la relación en el query para evitar N+1 queries
        return Inspection::query()->with('equipment');
    }
}
