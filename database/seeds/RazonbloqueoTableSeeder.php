<?php

use Illuminate\Database\Seeder;

class RazonbloqueoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('razonbloqueos')->insert(array(
           array('nombre' => 'Mantenimiento'),
           array('nombre' => 'Futura Venta'),
           array('nombre' => 'Late Check Out'),
           array('nombre' => 'Prestamo'),
           array('nombre' => 'Mal Olor'),
       ));
    }
}
