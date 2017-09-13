<?php

namespace Teodolinda\Listeners;

use Teodolinda\Events\Revisiondecubetafoliocargo;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Teodolinda\BitacoraFolioCargo;
use Illuminate\Support\Facades\Auth;

class CreaterevisioncubetafoliocargoEntry
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
     * @param  Revisiondecubetafoliocargo  $event
     * @return void
     */
    public function handle(Revisiondecubetafoliocargo $event)
    {
        $foliocargo = $event->folio_cargo_id;
        $revisioncubeta = new BitacoraFolioCargo();
        $revisioncubeta->folio_cargo_id = $foliocargo;
        $revisioncubeta->user_id = Auth::id();
        $revisioncubeta->bitacora_tipo_cambio_id = 4;
        $revisioncubeta->save();
    }
}
