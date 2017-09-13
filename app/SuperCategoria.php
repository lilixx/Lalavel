<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class SuperCategoria extends Model
{
    protected $fillable = [
        'nombre',
    ];

    public function categorias()
    {
       return $this->hasMany(Categoria::class);
    }

}
