<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntidadMedioComunicacione extends Model
{
    protected $fillable = [
       'mediocomunicacione_id', 'entidade_id', 'valormediocomunicacion',
    ];

    public function entidad()
    {
      return $this->belongsTo(Entidade::class);
    }
}
