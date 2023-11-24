<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Denuncia;
use App\Models\Documento;
use App\Models\Fotos;
use Illuminate\Support\Carbon;

class DenunciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imagenes = [
            'https://res.cloudinary.com/dirau81x6/image/upload/v1700828735/msyqkcx8lxyxf9c2kt7f.jpg',
            'https://res.cloudinary.com/dirau81x6/image/upload/v1700837157/xyayqle1i1vyzrhgccbs.png',
            'https://res.cloudinary.com/dirau81x6/image/upload/v1700828733/ucluxqhphmgkchm2a3mz.jpg'
        ];

        $publicIds = [
            'sedaiboi4khgvnl37avc',
            'tyuqqvaobbaecpigf1nb',
            'ezsv7oauynmyciv4lnig'
        ];
        for ($iterator=0; $iterator < 10 ; $iterator++) { 
            $documento = Documento::create([
                'foto'=> $imagenes[$iterator % 2],
                'secure_url'=>$imagenes[$iterator % 2],
                'public_id'=>$publicIds[$iterator % 2],
            ]);
            $denuncia = Denuncia::create([
                'nombre'=>fake()->name(),
                'apellidos'=>fake()->lastName(),
                'genero' => $iterator % 2,
                'fecha_nacimiento' => Carbon::now()->format('Y-m-d'),
                'altura'=> 1.55,
                'peso'=> '60',
                'cicatriz' => 'no tiene',
                'tatuaje'=> 'no tiene',
                'direccion'=> 'no tiene',
                'color_cabello'=> 1,
                'color_ojos' => 1,
                'fecha_desaparicion'=>Carbon::now()->format('Y-m-d'),
                'hora_desaparicion'=>Carbon::now()->format('h:m:s'),
                'ultima_ropa_puesta'=> 'Polera blanca pantalon azulado',
                'ubicacion'=>"{'latitude': -17.7962146394544$iterator, 'longitude': -63.2156652957200$iterator}",
                'user_id'=>$iterator + 1,
                'nacionalidad_id' => 1,
                'documento_id'=>$iterator + 1,
                'idioma_id'=>2,
            ]);

            $foto =Fotos::create([
                'foto' => $imagenes[$iterator % 2],
                'public_id' => $publicIds[$iterator % 2],
                'secure_url' => $imagenes[$iterator % 2],
                'denuncia_id'=>$denuncia->id,
            ]);
        }

    }
}
