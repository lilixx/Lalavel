<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class Bloqueo extends Model
{
    protected $fillable = [
        'razonbloqueo_id', 'habitacione_id', 'fechainicio', 'fechafin', 'comentario'
    ];

    public function razonbloqueo()
    {
      return $this->belongsTo(Razonbloqueo::class);
    }

    public function habitacione()
    {
      return $this->belongsTo(Habitacione::class);
    }

}
