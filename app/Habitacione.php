<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class Habitacione extends Model
{
      protected $fillable = [
          'habitacion_tipo_id', 'numero', 'limpia', 'disponible',
      ];

      public function habitaciontipo()
      {
        return $this->belongsTo('\Teodolinda\HabitacionTipo', 'habitacion_tipo_id');
      }

    
}
