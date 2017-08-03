<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservacionHabitacione extends Model
{
    protected $fillable = [
       'habitacione_id', 'tarifa_id', 'fechaentrada', 'fechasalida',
    ];

    public function habitacione()
    {
      return $this->belongsTo(Habitacione::class);
    }

    public function tarifa()
    {
      return $this->belongsTo(Tarifa::class);
    }
}
