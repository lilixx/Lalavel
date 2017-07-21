<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'nombre', 'supercategoria_id',
    ];

    public function supercategoria()
    {
      return $this->belongsTo(SuperCategoria::class);
    }

    public function servicios()
    {
       return $this->hasMany(Servicio::class);
    }
}
