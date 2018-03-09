<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class Reservacione extends Model
{
    protected $fillable = [
       'reservacionprocedencia_id', 'entidadtarjeta_id', 'confirmada', 'activo', 
    ];

    public function reservacionhabitaciones()
    {
       return $this->hasMany(ReservacionHabitacione::class);
    }

    public function reservacionentidadroles()
    {
       return $this->hasMany(ReservacionEntidadRole::class);
    }
}
