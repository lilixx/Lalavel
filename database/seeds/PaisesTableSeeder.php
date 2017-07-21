<?php

use Illuminate\Database\Seeder;

class PaisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paises')->insert(array(
           array('nombre' => 'Nicaragua'),
           array('nombre' => 'Costa Rica'),
           array('nombre' => 'El Salvador'),
           array('nombre' => 'Honduras'),
           array('nombre' => 'Guatemala'),
           array('nombre' => 'Panama'),

       ));
    }
}
