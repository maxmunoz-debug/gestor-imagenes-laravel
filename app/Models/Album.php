<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $primaryKey = 'album_id';

    protected $fillable = ['album_nombre', 'album_descripcion', 'usuario_id'];

    // Relación: Un álbum contiene muchas fotos
    public function fotos()
    {
        return $this->hasMany(Foto::class, 'album_id', 'album_id');
    }
}