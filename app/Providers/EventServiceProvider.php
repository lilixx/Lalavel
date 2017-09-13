<?php

namespace Teodolinda\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        'Teodolinda\Events\Creaciondefoliocargo' => [
            'Teodolinda\Listeners\CreatedfoliocargosEntry',
        ],

        'Teodolinda\Events\Enviocubetafoliocargo' => [
            'Teodolinda\Listeners\CreatedenviocubetaEntry',
        ],

        'Teodolinda\Events\Cambiodefoliocargo' => [
            'Teodolinda\Listeners\CreatecambiofoliocargoEntry',
        ],

        'Teodolinda\Events\Revisiondecubetafoliocargo' => [
            'Teodolinda\Listeners\CreaterevisioncubetafoliocargoEntry',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
