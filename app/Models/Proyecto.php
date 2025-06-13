<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'id_creador',
        'members',
        'firestore_id',
        'fecha_creacion',
        'tiempo_acumulado'
    ];

    protected $casts = [
        'members' => 'array',
        'fecha_creacion' => 'datetime',
    ];

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'id_creador');
    }

    // Proyecto.php
    public function toArray()
    {
        $array = parent::toArray();

        if ($this->fecha_creacion) {
            $array['fecha_creacion'] = $this->fecha_creacion->getTimestampMs(); // Laravel 9+
            // O usa ->timestamp * 1000 si estás en Laravel < 9
        }

        return $array;
    }

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_proyecto', 'proyecto_id', 'usuario_id');
    }

    public function miembros()
{
    return $this->belongsToMany(User::class, 'proyecto_miembros', 'proyecto_id', 'user_id');
}





}