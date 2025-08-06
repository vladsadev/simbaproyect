<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_type_id',
        'code',
        'brand',
        'model',
        'year',
        'status',
        'location',
        'length',
        'width',
        'height',
        'weight',
        'fuel_type',
        'engine_power',
        'fuel_capacity',
        'bucket_capacity',
        'max_load',
        'last_maintenance',
        'next_maintenance',
        'notes'
    ];

    protected $casts = [
        'year' => 'integer',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
    ];

    /**
     * Relaciones
     */
    public function equipmentType(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }

//    public function dailyReports(): HasMany
//    {
//        return $this->hasMany(DailyReport::class);
//    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    /**
     * Scopes útiles
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOfType($query, $typeName)
    {
        return $query->whereHas('equipmentType', function ($query) use ($typeName) {
            $query->where('name', $typeName);
        });
    }

    /**
     * ⭐ MÉTODOS CALCULADOS para obtener horas trabajadas
     */

    // Total de horas trabajadas (suma de todos los reportes)
    public function getTotalHoursWorkedAttribute(): float
    {
        return $this->dailyReports()->sum('hours_worked');
    }

    // Horas trabajadas en un periodo específico
    public function getHoursWorkedInPeriod($startDate, $endDate): float
    {
        return $this->dailyReports()
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('hours_worked');
    }

    // Horas trabajadas en el mes actual
    public function getHoursWorkedThisMonth(): float
    {
        return $this->dailyReports()
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->sum('hours_worked');
    }

    // Promedio de horas por día en el último mes
    public function getAverageHoursPerDay(): float
    {
        $reports = $this->dailyReports()
            ->where('date', '>=', now()->subMonth())
            ->get();

        return $reports->isEmpty() ? 0 : $reports->avg('hours_worked');
    }

    /**
     * Accessors
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->equipmentType->name} {$this->code}";
    }
}
