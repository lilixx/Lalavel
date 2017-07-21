<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HabitacionTipo extends Model
{
    protected $fillable = [
        'nombre', 'urlimg', 'tarifainicial',
    ];

    public function habitacione()
    {
       return $this->hasMany('\App\Habitacione', 'habitacion_tipo_id')->where('habitaciones.disponible', '=', 1);
    }

    public function tarifa()
    {
       return $this->hasMany('\App\Tarifa', 'habitaciontipo_id');
    }


}
