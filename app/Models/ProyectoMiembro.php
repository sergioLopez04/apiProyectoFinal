<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoMiembro extends Model
{
    use HasFactory;

    protected $table = 'proyecto_miembros';

    protected $fillable = [
        'proyecto_id',
        'user_id',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
