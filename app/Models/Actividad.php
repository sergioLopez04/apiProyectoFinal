<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    protected $fillable = [
        'proyecto_id',
        'fecha',
        'tiempo_inicio',
        'tiempo_fin',
        'duracion',
        'user_id'
    ];

    protected $appends = ['duracion'];

    public function getDuracionAttribute()
    {
        return $this->tiempo_fin - $this->tiempo_inicio;
    }

    public function getFechaAttribute($value)
    {
        return Carbon::parse($value)->toIso8601String();
    }


    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

}