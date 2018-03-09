<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'nombreservicio', 'categoria_id', 'descripcion',
    ];

    public function categoria()
    {
      return $this->belongsTo(Categoria::class);
    }

    public function tarifa()
    {
      return $this->hasMany(Tarifa::class);
    }
}
