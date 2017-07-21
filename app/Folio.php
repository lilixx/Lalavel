<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folio extends Model
{
    protected $fillable = [
        'estadia_id', 'entidadrole_id', 'foliopadre_id', 'comentario', 'credito', 'exoneracion', 'documento',
    ];

    public function entidaderole()
    {
      return $this->belongsTo(EntidadeRole::class);
    }

    public function foliorestrinccioncategorias()
    {
       return $this->hasMany(FolioRestrinccionCategoria::class);
    }

    public function foliocargos()
    {
       return $this->hasMany(FolioCargo::class);
    }

    public function estadia()
    {
      return $this->belongsTo(Estadia::class);
    }
}
