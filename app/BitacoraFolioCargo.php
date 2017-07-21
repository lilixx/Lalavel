<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BitacoraFolioCargo extends Model
{
    /*  protected $fillable = [
         'foliocargo_id', 'user_id', 'cambiofoliocargo_id',
      ]; */

    protected $table = 'bitacora_folio_cargos';

    public function foliocargo()
    {
      return $this->belongsTo(FolioCargo::class);
    }

    public function cambiofoliocargo()
    {
      return $this->belongsTo(CambioFolioCargo::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

}
