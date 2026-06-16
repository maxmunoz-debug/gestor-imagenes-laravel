<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    // Indicamos que la clave primaria es 'foto_id'
    protected $primaryKey = 'foto_id';

    // Campos que se pueden llenar masivamente
    protected $fillable = ['foto_nombre', 'foto_descripcion', 'foto_ruta', 'album_id'];

    // Relación: Una foto pertenece a un álbum
    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'album_id');
    }
}