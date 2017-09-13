<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class ReservacionEntidadRole extends Model
{
    protected $fillable = [
       'reservacion_habitacione_id', 'entidad_role_id', 'encargado',
    ];


}
