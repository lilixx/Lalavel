<?php

use Illuminate\Database\Seeder;

class TipoEntidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_entidades')->insert(array(
           array('nombre' => 'Natural'),
           array('nombre' => 'Empresa'),
           array('nombre' => 'Tour Operadora'),
       ));
    }
}
