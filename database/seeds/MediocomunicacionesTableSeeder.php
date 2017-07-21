<?php

use Illuminate\Database\Seeder;

class MediocomunicacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('medio_comunicaciones')->insert(array(
         array('nombre' => 'Teléfono'),
         array('nombre' => 'Correo'),
      ));
    }
}
