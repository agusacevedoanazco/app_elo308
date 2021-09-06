<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo, en este caso es necesario definir el nombre, dado que la tabla no cumple con la
     * convencion nombre modelo - nombre tabla (publicacions != publicaciones)
     *
     * @var string
     */
    protected $table = 'publicaciones';

    public function evento()
    {
        return $this->belongsTo(Evento::class,'id_evento','id');
    }
}
