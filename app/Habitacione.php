<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitacione extends Model
{
      protected $fillable = [
          'habitacion_tipo_id', 'numero', 'limpia', 'disponible',
      ];

      public function habitaciontipo()
      {
        return $this->belongsTo('\App\HabitacionTipo', 'habitacion_tipo_id');
      }

    
}
