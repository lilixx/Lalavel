<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class EstadiaHabitacione extends Model
{
    protected $fillable = [
        'habitacione_id', 'estadia_id', 'tarifa_id', 'fechaentrada', 'fechasalida', 'comentario',
    ];

    public function entidades()
    {
       return $this->belongsToMany('Teodolinda\Entidade')->withPivot('fechaentrada')->withTimestamps();
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
