<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadia extends Model
{
    protected $fillable = [
        'reservacione_id', 'comentario',
    ];

    public function estadiahabitaciones()
    {
       return $this->hasMany(EstadiaHabitacione::class);
    }

    public function folio()
    {
      return $this->hasMany(Folio::class);
    }
}
