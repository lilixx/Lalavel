<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'nombreservicio', 'categoria_id', 'precio', 'descripcion',
    ];

    public function categoria()
    {
      return $this->belongsTo(Categoria::class);
    }
}
