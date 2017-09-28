<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class HabitacionArea extends Model
{
    protected $fillable = [
        'nombre',
    ];

    public function habitaciones()
    {
       return $this->hasMany(Habitacione::class);
    }
}
