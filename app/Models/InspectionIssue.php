<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionIssue extends Model
{
    protected $fillable = [
        'inspection_id',
        'user_id',
        'component',
        'issue_type',
        'severity',
        'description',
        'recommended_action',
        'reported_at',
        'resolved_at',
        'status'
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function issues()
    {
        return $this->hasMany(InspectionIssue::class);
    }

// Útil para saber si tiene problemas
    public function hasIssues()
    {
        return $this->issues()->exists();
    }

// Para obtener el conteo
    public function issuesCount()
    {
        return $this->issues()->count();
    }


}


