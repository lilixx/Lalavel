<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PaisesTableSeeder::class);
        $this->call(TipoDocumentosTableSeeder::class);
        $this->call(MediocomunicacionesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(TipoEntidadesTableSeeder::class);
        $this->call(BitacoraTipoCambiosTableSeeder::class);
        $this->call(ReservacionProcedenciasTableSeeder::class);

    }
}
