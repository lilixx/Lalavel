<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadiaHabitacione extends Model
{

    public function entidades()
    {
       return $this->belongsToMany('App\Entidade')->withPivot('fechaentrada')->withTimestamps();
    }

    public function habitacione()
    {
       return $this->belongsTo(Habitacione::class);
    }

    public function estadia()
    {
       return $this->belongsTo(Estadia::class);
    }

    public function tarifa()
    {
       return $this->belongsTo(Tarifa::class);
    }

}
