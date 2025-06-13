<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'firebase_uid',
        'nombre',
        'email',
    ];

    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'usuario_proyecto', 'usuario_id', 'proyecto_id');
    }

    public function proyectosComoMiembro()
    {
        return $this->belongsToMany(Proyecto::class, 'proyecto_miembros', 'user_id', 'proyecto_id');
    }


}
