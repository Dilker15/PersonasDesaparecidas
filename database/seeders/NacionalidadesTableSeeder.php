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
            ['nacionalidad' => 'Mexicano', 'pais' => 'México', 'code_icon'=> 'MX'],
            ['nacionalidad' => 'Estadounidense', 'pais' => 'Estados Unidos', 'code_icon'=> 'US'],
            ['nacionalidad' => 'Canadiense', 'pais' => 'Canadá', 'code_icon'=> 'CA'],
            ['nacionalidad' => 'Español', 'pais' => 'España', 'code_icon'=> 'ES'],
            ['nacionalidad' => 'Argentino', 'pais' => 'Argentina', 'code_icon'=> 'AR'],
            ['nacionalidad' => 'Brasileño', 'pais' => 'Brasil', 'code_icon'=> 'BR'],
            ['nacionalidad' => 'Frances', 'pais' => 'Francia', 'code_icon'=> 'FR'],
            ['nacionalidad' => 'Aleman', 'pais' => 'Alemania', 'code_icon'=> 'AL'],
            ['nacionalidad' => 'Japones', 'pais' => 'Japón', 'code_icon'=> 'JA'],
            ['nacionalidad' => 'Chino', 'pais' => 'China', 'code_icon'=> 'CH'],
            ['nacionalidad' => 'Ingles', 'pais' => 'Reino Unido', 'code_icon'=> 'RU'],
            ['nacionalidad' => 'Australiano', 'pais' => 'Australia', 'code_icon'=> 'AU'],
            ['nacionalidad' => 'Sudafricano', 'pais' => 'Sudáfrica', 'code_icon'=> 'SA'],
            ['nacionalidad' => 'Ruso', 'pais' => 'Rusia', 'code_icon'=> 'RE'],
            ['nacionalidad' => 'Italiano', 'pais' => 'Italia', 'code_icon'=> 'IT'],
            ['nacionalidad' => 'Chileno', 'pais' => 'Chile', 'code_icon'=> 'CH'],
            ['nacionalidad' => 'Colombiano', 'pais' => 'Colombia', 'code_icon'=> 'CO'],
            ['nacionalidad' => 'Peruano', 'pais' => 'Perú', 'code_icon'=> 'PE'],
            ['nacionalidad' => 'Venezolano', 'pais' => 'Venezuela', 'code_icon'=> 'VE'],
            ['nacionalidad' => 'Boliviano', 'pais' => 'Venezuela', 'code_icon'=> 'BO'],
        ];

        foreach ($nacionalidades as $nacionalidad) {
            DB::table('nacionalidades')->insert([
                'nacionalidad' => $nacionalidad['nacionalidad'],
                'pais' => $nacionalidad['pais'],
                'code_icon' => $nacionalidad['code_icon'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
