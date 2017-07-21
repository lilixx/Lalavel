<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $fillable = [
        'nombre', 'valor', 'habitaciontipo_id',
    ];
    public function habitaciontipo()
    {
      return $this->belongsTo(HabitacionTipo::class);
    }
}
