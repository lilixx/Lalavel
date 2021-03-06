<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class ReservacionHabitacione extends Model
{
    protected $fillable = [
       'habitacione_id', 'tarifa_id', 'fechaentrada', 'fechasalida', 'comentario',
    ];

    public function habitacione()
    {
      return $this->belongsTo(Habitacione::class);
    }

    public function reservacione()
    {
      return $this->belongsTo(Reservacione::class);
    }

    public function tarifa()
    {
      return $this->belongsTo(Tarifa::class);
    }
}
