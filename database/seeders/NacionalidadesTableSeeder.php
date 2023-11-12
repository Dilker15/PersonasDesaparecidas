<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NacionalidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nacionalidades = [
            ['nacionalidad' => 'Mexicana', 'pais' => 'México'],
            ['nacionalidad' => 'Estadounidense', 'pais' => 'Estados Unidos'],
            ['nacionalidad' => 'Canadiense', 'pais' => 'Canadá'],
            ['nacionalidad' => 'Española', 'pais' => 'España'],
            ['nacionalidad' => 'Argentina', 'pais' => 'Argentina'],
            ['nacionalidad' => 'Brasileña', 'pais' => 'Brasil'],
            ['nacionalidad' => 'Francesa', 'pais' => 'Francia'],
            ['nacionalidad' => 'Alemana', 'pais' => 'Alemania'],
            ['nacionalidad' => 'Japonesa', 'pais' => 'Japón'],
            ['nacionalidad' => 'China', 'pais' => 'China'],
            ['nacionalidad' => 'Canadiense', 'pais' => 'Canadá'],
            ['nacionalidad' => 'Inglesa', 'pais' => 'Reino Unido'],
            ['nacionalidad' => 'Australiana', 'pais' => 'Australia'],
            ['nacionalidad' => 'Sudafricana', 'pais' => 'Sudáfrica'],
            ['nacionalidad' => 'Rusa', 'pais' => 'Rusia'],
            ['nacionalidad' => 'Italiana', 'pais' => 'Italia'],
            ['nacionalidad' => 'Chilena', 'pais' => 'Chile'],
            ['nacionalidad' => 'Colombiana', 'pais' => 'Colombia'],
            ['nacionalidad' => 'Peruana', 'pais' => 'Perú'],
            ['nacionalidad' => 'Venezolana', 'pais' => 'Venezuela'],
        ];

        foreach ($nacionalidades as $nacionalidad) {
            DB::table('nacionalidades')->insert([
                'nacionalidad' => $nacionalidad['nacionalidad'],
                'pais' => $nacionalidad['pais'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
