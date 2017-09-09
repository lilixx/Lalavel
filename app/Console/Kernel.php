<?php

namespace App\Console;

use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       $schedule->call(function () {
          $now = \Carbon\Carbon::now();
          $habitaciones= DB::table('estadia_habitaciones')
          ->where('estadia_habitaciones.activo', 1)
          ->join('folios', 'folios.estadia_id', '=', 'estadia_habitaciones.estadia_id')
          ->select('estadia_habitaciones.tarifa_id', 'estadia_habitaciones.id as idestadiahab', 'folios.id as idfolio')
          ->get();

          foreach($habitaciones as $key=> $hab){
            $containers[] = ([
                                'estadia_habitacione_id'=>$hab->idestadiahab,
                                'servicio_id'=>1,
                                'folio_id'=>$hab->idfolio,
                                'tarifa_id' => $hab->tarifa_id,
                                'created_at' => $now,
                                'updated_at' => $now,
                                'cantidad' => 1,

                            ]);
          } DB::table('folio_cargos')->insert($containers);

     })->daily();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
