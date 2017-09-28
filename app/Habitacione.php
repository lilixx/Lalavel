<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class Habitacione extends Model
{
      protected $fillable = [
          'habitacion_tipo_id', 'habitacion_area_id', 'numero', 'limpia', 'disponible', 'comentario',
      ];

      public function habitaciontipo()
      {
        return $this->belongsTo('\Teodolinda\HabitacionTipo', 'habitacion_tipo_id');
      }

      public function habitacionarea()
      {
        return $this->belongsTo('\Teodolinda\HabitacionArea', 'habitacion_area_id');
      }


}
