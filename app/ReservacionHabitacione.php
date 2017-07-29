<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservacionHabitacione extends Model
{
    public function habitacione()
    {
      return $this->belongsTo(Habitacione::class);
    }

    public function tarifa()
    {
      return $this->belongsTo(Tarifa::class);
    }
}
