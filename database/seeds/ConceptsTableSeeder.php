<?php

use Illuminate\Database\Seeder;

class ConceptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('concepts')->insert([
            'name' => 'Cuota ordinaria',
        ]);
       DB::table('concepts')->insert([
            'name' => 'Cuota extra',
        ]);
       DB::table('concepts')->insert([
            'name' => 'Interes',
        ]);
       DB::table('concepts')->insert([
            'name' => 'Sancion',
        ]);
       DB::table('concepts')->insert([
            'name' => 'Gasto legal',
        ]);
       DB::table('concepts')->insert([
            'name' => 'Parqueadero visitante',
        ]);
       DB::table('concepts')->insert([
            'name' => 'Nota debito',
        ]);
       DB::table('concepts')->insert([
            'name' => 'Nota credito',
        ]);
       DB::table('concepts')->insert([
            'name' => 'Zona comun',
        ]);
       DB::table('concepts')->insert([
            'name' => 'Otros',
        ]);
       DB::table('concepts')->insert([
            'name' => 'Descuento',
        ]);
    }
}
