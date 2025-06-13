<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyecto_id',
        'descripcion',
        'completada',
        'prioridad',
        'fecha_inicio',
        'fecha_fin',
    ];


    protected $casts = [
        'completada' => 'boolean',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
}