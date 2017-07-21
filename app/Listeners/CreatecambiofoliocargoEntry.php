<?php

namespace App\Listeners;

use App\Events\Cambiodefoliocargo;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\BitacoraFolioCargo;
use Illuminate\Support\Facades\Auth;

class CreatecambiofoliocargoEntry
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Cambiodefoliocargo  $event
     * @return void
     */
    public function handle(Cambiodefoliocargo $event)
    {
        $idfolio = $event->folio_id;
        $foliodestino = $event->foliodestino_id;
        $idfoliocargo = $event->folio_cargo_id;
        $foliocargo_entry = new BitacoraFolioCargo();
        $foliocargo_entry->folio_id = $idfolio;
        $foliocargo_entry->foliodestino_id = $foliodestino;
        $foliocargo_entry->folio_cargo_id = $idfoliocargo;
        $foliocargo_entry->user_id = Auth::id();
        $foliocargo_entry->bitacora_tipo_cambio_id = 3;
        $foliocargo_entry->save();
    }
}
