<?php

namespace App\Listeners;

use App\Events\Enviocubetafoliocargo;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\BitacoraFolioCargo;
use Illuminate\Support\Facades\Auth;

class CreatedenviocubetaEntry
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
     * @param  Enviocubetafoliocargo  $event
     * @return void
     */
    public function handle(Enviocubetafoliocargo $event)
    {
        $foliocargo = $event->folio_cargo_id;
        $enviocubeta = new BitacoraFolioCargo();
        $enviocubeta->folio_cargo_id = $foliocargo;
        $enviocubeta->user_id = Auth::id();
        $enviocubeta->bitacora_tipo_cambio_id = 2;
        $enviocubeta->save();
    }
}
