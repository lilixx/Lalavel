<?php

use Illuminate\Database\Seeder;

class BitacoraTipoCambiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bitacora_tipo_cambios')->insert(array(
           array('nombre' => 'Cargo al folio'),
           array('nombre' => 'Envio a cubeta'),
           array('nombre' => 'Movimiento de cargo a otro folio'),
           array('nombre' => 'Aprobacion de cargo en cubeta'),
       ));
    }
}
