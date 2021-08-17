<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_oc',
        'titulo',
        'descripcion',
        'publicado',
        'error',
    ];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class,'id_asignatura','id');
    }
}