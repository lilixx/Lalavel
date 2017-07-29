<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EntidadeEstadiaHabitacione extends Pivot
{
    protected $fillable = [
        'entidade_id', 'estadia_habitacione_id',
    ];

    public function entidade() {
       return $this->belongsTo(Entidade::class);
   }

   public function estadiahabitacione() {
       return $this->belongsTo(EstadiaHabitacione::class);
   }
}
