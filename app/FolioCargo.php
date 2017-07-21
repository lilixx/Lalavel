<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FolioCargo extends Model
{
    protected $fillable = [
       'servicio_id', 'folio_id', 'descuento_id', 'cantidad', 'comentariocubeta', 'cubeta', 'activo',
    ];

    public function folio()
    {
      return $this->belongsTo(Folio::class);
    }

    public function servicio()
    {
      return $this->belongsTo(Servicio::class);
    }

    public function descuento()
    {
      return $this->belongsTo(Descuento::class);
    }

    public function bitacorafoliocargos()
    {
       return $this->hasMany(BitacoraFolioCargo::class);
    }

}
