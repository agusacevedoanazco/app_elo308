<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'oc_series_id',
        'oc_series_name',
        'nombre',
        'anio',
        'semestre',
        'paralelo',
        'codigo',
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class,'id_departamento','id');
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class,'id_asignatura','id')->orderByDesc('updated_at');
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class,'participantes','id_asignatura','id_user');
    }
}
