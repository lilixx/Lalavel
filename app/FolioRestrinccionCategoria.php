<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FolioRestrinccionCategoria extends Model
{
    protected $fillable = [
       'categoria_id', 'folio_id'
    ];

    public function folio()
    {
      return $this->belongsTo(Folio::class);
    }

    public function categoria()
    {
      return $this->belongsTo(Categoria::class);
    }
}
