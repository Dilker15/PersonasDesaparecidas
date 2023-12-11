<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avistamiento;
use App\Models\FotoAvistamiento;
use App\Models\Denuncia;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AvistamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

     public function subirCloudinary($rutaDestino){

        $imagen = Cloudinary::upload($rutaDestino,['folders'=>'fotografos']);
        return $imagen;
    }

    public function store(Request $request)
    {

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token)->id;

        
        $avistamiento = Avistamiento::create([
            'descripcion' => $request['descripcion'],
            'ubicacion' => $request['ubicacion'],
            'fecha'=> $request['fecha'],
            'hora'=> $request['hora'],
            'denuncia_id' => $request['denuncia_id'],
            'contacto'=>$request['contacto'],
            'user_id'=>$user,
        ]);

        
        $imagenes = $request['imagenes'];
    
        foreach($imagenes as $imagen){
            $rutaImagen = $imagen; // aqui se debe obtener la foto del movil "FOTO POLICIAL"
            $name=time();
            $rutaDestino = sys_get_temp_dir().DIRECTORY_SEPARATOR."$name.jpg";

            rename($rutaImagen,$rutaDestino);

            $imagen1 =$this->subirCloudinary($rutaDestino);
            FotoAvistamiento::create([
                'foto'=>$imagen1->getSecurePath(),
                'public_id'=>$imagen1->getPublicId(),
                'avistamiento_id'=>$avistamiento->id
            ]);
        }

        return response()->json([
            'res'=>true,
            'datos' => "Avistamiento registrado con Exito"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    

        $avistamiento = Avistamiento::find($id);
        $jsonString = $avistamiento->ubicacion;
        $objetoPHP = json_decode($jsonString);
        $avistamiento->latitude=$objetoPHP->latitude;
        $avistamiento->longitude=$objetoPHP->longitude;
        return response()->json([
            'res'=>true,
            'datos' => $avistamiento,
            'fotos'=>$avistamiento->fotos
        ]);

    }



    public function getHistorialAvistamientos($denuncia_id){

        $denuncia = Denuncia::find($denuncia_id);
        $avistamientos = $denuncia->avistamientos;

        $fotos="";
            foreach($avistamientos as $avistamiento){
                $fotos = $avistamiento->fotos."\n";
                $jsonString = $avistamiento->ubicacion;
                $objetoPHP = json_decode($jsonString);
                $avistamiento->latitude=$objetoPHP->latitude;
                $avistamiento->longitude=$objetoPHP->longitude;
                

            }
        
        return response()->json([
            'res'=>true,
            'datos'=>$denuncia->avistamientos,
            // 'fotos'=>$fotos,

        ]);
    }



    public function mostrarFechasHoras(Request $request){

        $id = $request['denuncia_id'];
        $avistamientos = Avistamiento::where('denuncia_id',$id)->orderByRaw('fecha asc, hora asc')->get();

        foreach($avistamientos as $avistamiento){
            $jsonString = $avistamiento->ubicacion;
            $objetoPHP = json_decode($jsonString);
            $avistamiento->latitude=$objetoPHP->latitude;
            $avistamiento->longitude=$objetoPHP->longitude;

        }
        return response()->json([
             'res'=>true,
             'datos' => $avistamientos,
        ]);

    }


    



    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
