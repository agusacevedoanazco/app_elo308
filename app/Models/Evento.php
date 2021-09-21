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
        'temp_filename',
        'temp_directory',
        'autor',
        'pendiente',
        'error',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class,'id_curso','id');
    }

    public function publicacion()
    {
        return $this->hasOne(Publicacion::class,'id_evento','id');
    }
}
