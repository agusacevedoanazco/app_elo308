<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'sigla',
        'carrera',
    ];

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class, 'id_departamento','id');
    }
}