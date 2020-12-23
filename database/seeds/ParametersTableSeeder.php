<?php

use Illuminate\Database\Seeder;

class ParametersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('parameters')->insert([
            'name' => 'Nombre Administrador',
            'value' => 'Forzzeti Property Management',
        ]);
       DB::table('parameters')->insert([
            'name' => 'Tipo Documento Administrador',
            'value' => 'NIT',
        ]);
       DB::table('parameters')->insert([
            'name' => 'Documento Administrador',
            'value' => '1234',
        ]);
       DB::table('parameters')->insert([
            'name' => 'Dia Cierre',
            'value' => '30',
        ]);
       DB::table('parameters')->insert([
            'name' => 'Correo Administrador',
            'value' => 'prueba@gmail.com',
        ]);
       DB::table('parameters')->insert([
            'name' => 'Firma Digital',
            'value' => ' ',
        ]);
    }
}
