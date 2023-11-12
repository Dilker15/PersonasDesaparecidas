<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colores = [
            'Rojo',
            'Azul',
            'Verde',
            'Amarillo',
            'Blanco',
            'Negro',
            'Naranja',
            'Rosado',
            'Gris',
            'Morado',
        ];

        foreach ($colores as $color) {
            DB::table('colores')->insert([
                'nombre' => $color,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
