<?php

use Illuminate\Database\Seeder;

class TipoDocumentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_documentos')->insert(array(
           array('nombre' => 'Cedula'),
           array('nombre' => 'Pasaporte ORD'),
           array('nombre' => 'Pasaporte OFIC'),
           array('nombre' => 'Pasaporte DIPLO'),

       ));
    }
}
