<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(array(
           array('nombre' => 'Huesped'),
           array('nombre' => 'Cliente'),
           array('nombre' => 'Recepcionista'),
           array('nombre' => 'Admin'),
       ));
    }
}
