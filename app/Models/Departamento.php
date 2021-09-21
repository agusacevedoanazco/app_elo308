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
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class,'id_departamento','id');
    }
}
