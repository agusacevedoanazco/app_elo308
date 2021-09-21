<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    public function departamento()
    {
        return $this->belongsTo(Departamento::class,'id_departamento','id');
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class,'id_curso','id')->orderByDesc('updated_at');
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class,'participantes','id_curso','id_user');
    }
}
