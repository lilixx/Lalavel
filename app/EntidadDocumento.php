<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntidadDocumento extends Model
{
    protected $fillable = [
      'entidade_id', 'tipodocumento_id', 'valordocumento'
    ];

    public function entidade()
    {
      return $this->belongsTo(Entidade::class);
    }
}
