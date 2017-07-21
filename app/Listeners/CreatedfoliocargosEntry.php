<?php

namespace App\Listeners;

use App\Events\Creaciondefoliocargo;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\BitacoraFolioCargo;
use Illuminate\Support\Facades\Auth;

class CreatedfoliocargosEntry
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
     * @param  Creaciondefoliocargo  $event
     * @return void
     */
    public function handle(Creaciondefoliocargo $event)
    {
        $idfolio = $event->folio_id;
        $foliocargo_entry = new BitacoraFolioCargo();
        $foliocargo_entry->folio_id = $idfolio;
        $foliocargo_entry->user_id = Auth::id();
        $foliocargo_entry->bitacora_tipo_cambio_id = 1;
        $foliocargo_entry->save();
    }
}
