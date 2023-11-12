<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposCabelloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposCabello = [
            'Liso',
            'Rizado',
            'Ondulado',
            'Crespo',
            'Liso y fino',
            'Liso y grueso',
            'Rizado y fino',
            'Rizado y grueso',
            'Ondulado y fino',
            'Ondulado y grueso',
        ];

        foreach ($tiposCabello as $tipo) {
            DB::table('tipos_cabello')->insert([
                'nombre' => $tipo,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
