<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\ColoresTableSeeder;
use Database\Seeders\IdiomasTableSeeder;
use Database\Seeders\NacionalidadesTableSeeder;
use Database\Seeders\TiposCabelloSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'daniel',
            'email' => 'daniel@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        $colores  = new ColoresTableSeeder();
        $colores->run();
        $idiomas  = new IdiomasTableSeeder();
        $idiomas->run();
        $nacionalidades  = new NacionalidadesTableSeeder();
        $nacionalidades->run();
        $tiposCabello  = new TiposCabelloSeeder();
        $tiposCabello->run();
        
    }
}
