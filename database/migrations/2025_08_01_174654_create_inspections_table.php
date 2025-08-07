<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();

            // Relación con equipo
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');

            // Información del inspector
            $table->string('inspector_name');
            $table->decimal('work_hours', 5, 2)->nullable();
            $table->string('operator_name')->nullable();

            // Fecha y hora de la inspección
            $table->timestamp('inspection_date');

            // Items de inspección (JSON para flexibilidad)
            $table->json('inspection_items'); // Guardará el estado de cada item

            // Estado general de la inspección
            $table->enum('status', ['completed', 'incomplete', 'pending'])->default('pending');

            // Observaciones
            $table->text('observations')->nullable();

            // Estadísticas
            $table->integer('total_items')->default(0);
            $table->integer('checked_items')->default(0);
            $table->decimal('completion_percentage', 5, 2)->default(0);

            $table->timestamps();

            // Índices
            $table->index(['equipment_id', 'status']);
            $table->index('inspection_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
