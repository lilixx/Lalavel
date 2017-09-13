<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class HabitacionTipo extends Model
{
    protected $fillable = [
        'nombre', 'urlimg', 'tarifainicial',
    ];

    public function habitacione()
    {
       return $this->hasMany('\Teodolinda\Habitacione', 'habitacion_tipo_id')->where('habitaciones.disponible', '=', 1);
      // ->where('reservacion_habitaciones.fechasalida', '>=', $salida)
      // ->orWhere('reservacion_habitaciones.fechasalida', '>', $salida);
    }

    public function tarifa()
    {
       return $this->hasMany('\Teodolinda\Tarifa', 'habitaciontipo_id');
    }


}
