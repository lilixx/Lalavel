<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntidadContacto extends Model
{
    protected $fillable = [
        'entidade_id', 'nombres', 'apellidos', 'email', 'telefono', 'cargo',
    ];

    public function entidade()
    {
      return $this->belongsTo(Entidade::class);
    }
}
