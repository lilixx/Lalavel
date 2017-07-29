<?php

use Illuminate\Database\Seeder;

class ReservacionProcedenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservacion_procedencias')->insert(array(
           array('nombre' => 'Sistema Interno'),
           array('nombre' => 'Sitio web'),
        
       ));
    }
}
