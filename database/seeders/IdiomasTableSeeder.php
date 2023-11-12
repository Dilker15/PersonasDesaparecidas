<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdiomasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idiomas = [
            'Inglés',
            'Español',
            'Chino Mandarín',
            'Hindi',
            'Árabe',
            'Portugués',
            'Bengalí',
            'Ruso',
            'Japonés',
            'Alemán',
        ];

        foreach ($idiomas as $idioma) {
            DB::table('idiomas')->insert([
                'nombre' => $idioma,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
