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
        Schema::create('inspection_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->string('component');
            $table->string('issue_type');
            $table->enum('severity', ['baja', 'media', 'alta', 'critica']);
            $table->text('description');
            $table->string('recommended_action');
            $table->timestamp('reported_at');
            $table->timestamp('resolved_at')->nullable();
            $table->enum('status', ['abierto', 'en_proceso', 'resuelto'])->default('abierto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_issues');
    }
};
