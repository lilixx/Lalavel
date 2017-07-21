<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntidadeRole extends Model
{
    protected $fillable = [
       'entidade_id', 'role_id'
    ];

    public function entidade()
    {
      return $this->belongsTo(Entidade::class);
    }

    public function folios()
    {
       return $this->hasMany(Folio::class);
    }
}
