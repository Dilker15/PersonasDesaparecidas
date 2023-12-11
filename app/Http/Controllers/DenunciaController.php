<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Support\Facades\Storage;
use App\Models\Denuncia;
use App\Models\Documento;
use App\Models\Fotos;
use App\Models\Telefonos;
use App\Models\Nacionalidad;
use App\Models\Idioma;
use App\Models\TipoCabello;
use App\Models\Color;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;


use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;




use Illuminate\Http\Request;

class DenunciaController extends Controller
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
    public function store(Request $request)
    {


        if($request->hasFile('foto_denuncia')){
        
                $rutaImagen = $request->file('foto_denuncia');   // aqui se debe obtener la foto del movil "FOTO POLICIAL"
                $name=time();
                $rutaDestino = sys_get_temp_dir().DIRECTORY_SEPARATOR."$name.jpg";
                rename($rutaImagen,$rutaDestino);



             $fotoCloud =$this->subirCloudinary($rutaDestino);
             $urlFotoDeLaDenuncia = $fotoCloud->getSecurePath();


            $datos = $this->extraerDatosDeLaDenuncia($urlFotoDeLaDenuncia);
            $cadena_a_buscar = "trata y trafico de personas";
            $nombreDe=strtolower($request['nombre'].' '.$request['apellidos']);

            $datos = strtolower($datos);
           
            // SE PUEDE AGREGAR EL NOMBRE QUE SE ENCUENTRA EN LOS CAMPOS DENUNCIA PARA MEJORAR LA BUSQUEDa
        
            if (true){//preg_match("/" . preg_quote($cadena_a_buscar, "/") . "/", $datos) && preg_match("/" . preg_quote($nombreDe, "/") . "/", $datos)) {
                //SI LLEGAMOS AQUI ES POR QUE TIENE UNA DENUNCIA VALIDA EN LA POLICIA.
                

                    if($request->hasFile('imagen1')){
                       if($request->hasFile('imagen2')){   // tiene 2 fotos del desaparecido
                            $rutaImagen = $request->file('imagen1');   // aqui se debe obtener la foto del movil "FOTO POLICIAL"
                            $name=time();
                            $rutaDestino = sys_get_temp_dir().DIRECTORY_SEPARATOR."$name.jpg";
                            rename($rutaImagen,$rutaDestino);

                            $imagen1 =$this->subirCloudinary($rutaDestino);
                            $urlImagen1 = $imagen1->getSecurePath();


                            // AQUI COMPARAMOS LA IMAGEN 2 

                            $rutaImagen2 = $request->file('imagen2');   // aqui se debe obtener la foto del movil "FOTO POLICIAL"
                            $name2=time();
                            $rutaDestino2 = sys_get_temp_dir().DIRECTORY_SEPARATOR."$name2.jpg";
                            rename($rutaImagen2,$rutaDestino2);

                            $imagen2 =$this->subirCloudinary($rutaDestino2);
                            $urlImagen2 = $imagen2->getSecurePath();

                            $esPersonaFoto1 = $this->verificarSiSonPersonas($urlImagen1);
                            $esPersonaFoto2 = $this->verificarSiSonPersonas($urlImagen2);

                           if($esPersonaFoto1 && $esPersonaFoto2){
                                $esFamosoFoto1 =  $this->verificarSiEsFamoso($urlImagen1);
                                $esFamosoFoto2 =  $this->verificarSiEsFamoso($urlImagen2);

                                if(!$esFamosoFoto1 && !$esFamosoFoto2){
                                    $documento = Documento::create([
                                        'foto'=>$urlFotoDeLaDenuncia,
                                        'secure_url'=>$urlFotoDeLaDenuncia,
                                        'public_id'=>$fotoCloud->getPublicId(),
                                    ]);

                                    $denuncia = Denuncia::create([
                                        'nombre'=>$request['nombre'],
                                        'apellidos'=>$request['apellidos'],
                                        'genero' =>$request['genero'],
                                        'fecha_nacimiento'=>$request['fecha_nacimiento'],
                                        'altura'=>$request['altura'],
                                        'peso'=>$request['peso'],
                                        'cicatriz' =>$request['cicatriz'],
                                        'tatuaje'=>$request['tatuaje'],
                                        'direccion'=>$request['direccion'],
                                        'color_cabello'=>$request['color_cabello'],
                                        'color_ojos' =>$request['color_ojos'],
                                        'fecha_desaparicion'=>$request['fecha_desaparicion'],
                                        'hora_desaparicion'=>$request['hora_desaparicion'],
                                        'ultima_ropa_puesta'=>$request['ultima_ropa_puesta'],
                                        'ubicacion'=>$request['ubicacion'],
                                        'user_id'=>$request['user_id'],
                                        'nacionalidad_id' => $request['nacionalidad_id'],
                                        'documento_id'=>$documento->id,
                                        'idioma_id'=>$request['idioma_id'],
                                        'enfermedad'=>$request['enfermedad'],
                                        'contacto' =>$request['contacto'],
                                    ]);

                                    $foto =Fotos::create([
                                        'foto'=>$urlImagen1,
                                        'public_id'=>$imagen1->getPublicId(),
                                        'secure_url'=>$urlImagen1,
                                        'denuncia_id'=>$denuncia->id,
                                    ]);
                                    $foto =Fotos::create([
                                        'foto'=>$urlImagen2,
                                        'public_id'=>$imagen2->getPublicId(),
                                        'secure_url'=>$urlImagen2,
                                        'denuncia_id'=>$denuncia->id,
                                    ]);

                                 

                                    return response()->json([
                                        'res' => true,
                                        'mensaje' => "Denuncia Creada Con exito"
                                    ]);

                                }
                                return response()->json([
                                    'res'=>false,
                                    'mensaje'=>"Ingrese Fotos de una persona no famosa"
                                ]);

                           }
                                return response()->json([
                                    'res'=>false,
                                    'mensaje' => "Las Fotos no son de una persona"
                                ]);
                                    
                           



                        }else{  
                                                    // tiene 1 foto del desaparecido
                            $rutaImagen = $request->file('imagen1');   // aqui se debe obtener la foto del movil "FOTO POLICIAL"
                            $name=time();
                            $rutaDestino = sys_get_temp_dir().DIRECTORY_SEPARATOR."$name.jpg";
                            rename($rutaImagen,$rutaDestino);

                            $imagen1 =$this->subirCloudinary($rutaDestino);
                            $urlImagen1 = $imagen1->getSecurePath();


                            $esPersonaFoto=$this->verificarSiSonPersonas($urlImagen1);

                            if($esPersonaFoto){

                                $esFamoso = $this->verificarSiEsFamoso($urlImagen1);
                                    if(!$esFamoso){
                                        $documento = Documento::create([
                                            'foto'=>$urlFotoDeLaDenuncia,
                                            'secure_url'=>$urlFotoDeLaDenuncia,
                                            'public_id'=>$imagen1->getPublicId(),
                                        ]);
                                        $denuncia = Denuncia::create([
                                            'nombre'=>$request['nombre'],
                                            'apellidos'=>$request['apellidos'],
                                            'genero' =>$request['genero'],
                                            'fecha_nacimiento'=>$request['fecha_nacimiento'],
                                            'altura'=>$request['altura'],
                                            'peso'=>$request['peso'],
                                            'cicatriz' =>$request['cicatriz'],
                                            'tatuaje'=>$request['tatuaje'],
                                            'direccion'=>$request['direccion'],
                                            'color_cabello'=>$request['color_cabello'],
                                            'color_ojos' =>$request['color_ojos'],
                                            'fecha_desaparicion'=>$request['fecha_desaparicion'],
                                            'hora_desaparicion'=>$request['hora_desaparicion'],
                                            'ultima_ropa_puesta'=>$request['ultima_ropa_puesta'],
                                            'ubicacion'=>$request['ubicacion'],
                                            'user_id'=>$request['user_id'], // numerico el id del user
                                            'nacionalidad_id' => $request['nacionalidad_id'],
                                            'documento_id'=>$documento->id, // NO
                                            'idioma_id'=>$request['idioma_id'], // numerico ID del idioma
                                            'enfermedad'=>$request['enfermedad'],
                                            'contacto' =>$request['contacto'],
                                        ]);

                                        $foto =Fotos::create([
                                            'foto'=>$urlImagen1,
                                            'public_id'=>$imagen1->getPublicId(),
                                            'secure_url'=>$urlImagen1,
                                            'denuncia_id'=>$denuncia->id,
                                        ]);

                                        return response()->json([
                                            'res'=>true,
                                            'mensaje'=>"Denuncia Creada con exito"
                                        ]);
                                    }

                                return response()->json([
                                    'res'=>false,
                                    'mensaje'=>"Ingrese Fotos de una persona no famosa"
                                ]);
                            }
                            return response()->json([
                                'res'=>false,
                                'mensaje' =>"La Foto No es de una persona"
                            ],400);

                        }
                    }

            }
                return response()->json([
                    'res'=>false,
                    'mensaje'=> "Ingrese una foto de La denuncia Policial de : ".$request['nombre']
                ],400);
               
            

        }

        return response()->json([
            'res'=>false,
            'datos'=>'Denuncia Invalida Ingrese datos validos'
        ],400);
        
    }


    public function subirCloudinary($rutaDestino){

        $imagen = Cloudinary::upload($rutaDestino,['folders'=>'fotografos']);
        return $imagen;
    }


    public function verificarSiSonPersonas($urlFoto){
        $cliente = new RekognitionClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' =>'latest'
        ]);
        $result = $cliente->detectLabels([
            'Image' => [
                'Bytes' => file_get_contents($urlFoto),
            ],
            'MaxLabels' => 15,
            'MinConfidence' => 80,
        ]);

        $result = $result['Labels'];
        $esPerson = false;
        foreach($result as $res){
            $res['Name']; /// AQUI ESTAN LAS ETIQUETAS DE LA IA EN FOTOS
           
                if($res['Name'] == 'Person' || $res['Name']== 'People'){
                    $esPerson = true;
                    break;
                }
        }
        return $esPerson;

    }


    public function extraerDatosDeLaDenuncia($urlFotoDeLaDenuncia){

        $cliente = new RekognitionClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' =>'latest'
        ]);

        $result = $cliente->detectText([
            'Image' => [
                'Bytes' => file_get_contents($urlFotoDeLaDenuncia),
            ],
        ]);

        $detectedText="";

        foreach ($result['TextDetections'] as $textDetection) {
            $detectedText .= $textDetection['DetectedText'] . ' ';
        }

        return $detectedText;
    }


   

    public function getHistorialDenuncias($user_id){
        $denuncias= Denuncia::where('user_id','=',$user_id)->get();
        $year = Carbon::now()->year;
            foreach($denuncias as $denuncia){
                $datos=Nacionalidad::find($denuncia->nacionalidad_id);
                $denuncia->nacionalidad_code=$datos->code_icon;
                $array = explode("-", $denuncia->fecha_nacimiento);
                
                $jsonString = $denuncia->ubicacion;
                $objetoPHP = json_decode($jsonString);
                $denuncia->latitude=$objetoPHP->latitude;
                $denuncia->longitude=$objetoPHP->longitude;

                $denuncia->edad = $year-$array[0];
                $datos = Documento::find($denuncia->documento_id);
                $denuncia->documento_id=$datos->foto;
                $datos = Idioma::find($denuncia->idioma_id);
                $denuncia->idioma_id =$datos->nombre;
                $denuncia->estado = $denuncia->estado_descripcion;
                $datos = Color::find($denuncia->color_ojos);
                $denuncia->color_ojos = $datos->nombre;
                $datos = Color::find($denuncia->color_cabello);
                $denuncia->color_cabello = $datos->nombre;
                $fotosDeLaDenuncia = Fotos::where('denuncia_id','=',$denuncia->id)->get();
                $sw=true;
                foreach ($fotosDeLaDenuncia as $foto) {
                    $urlFoto = $foto['foto'];
                    if($sw){
                        $denuncia->imagen1=$urlFoto;
                        $sw=false;
                    }else{
                        $denuncia->imagen2=$urlFoto;
                    }
                 }       
    
            }
         
        return response()->json([
            'res'=>true,
            'datos'=>$denuncias,
        ]);
    }



    public function mostrarDenuncia($id){
        
        $denuncia = Denuncia::find($id);
        $year = Carbon::now()->year;
                $datos=Nacionalidad::find($denuncia->nacionalidad_id);
                $denuncia->nacionalidad_code=$datos->code_icon;
                $denuncia->nacionalidad_id = $datos->nacionalidad;
                $array = explode("-", $denuncia->fecha_nacimiento);
                $jsonString = $denuncia->ubicacion;
                $objetoPHP = json_decode($jsonString);
                $denuncia->latitude=$objetoPHP->latitude;
                $denuncia->longitude=$objetoPHP->longitude;
                $denuncia->edad = $year-$array[0];
                $datos = Documento::find($denuncia->documento_id);
                $denuncia->documento_id=$datos->foto;
                $datos = Idioma::find($denuncia->idioma_id);
                $denuncia->idioma_id =$datos->nombre;
                $denuncia->estado = $denuncia->estado_descripcion;
                $datos = Color::find($denuncia->color_ojos);
                $denuncia->color_ojos = $datos->nombre;
                $datos = Color::find($denuncia->color_cabello);
                $denuncia->color_cabello = $datos->nombre;
                $fotosDeLaDenuncia = Fotos::where('denuncia_id','=',$denuncia->id)->get();
                $sw=true;
                foreach ($fotosDeLaDenuncia as $foto) {
                    $urlFoto = $foto['foto'];
                    if($sw){
                        $denuncia->imagen1=$urlFoto;
                        $sw=false;
                    }else{
                        $denuncia->imagen2=$urlFoto;
                    }
                 }       
    
         
        return response()->json([
            'res'=>true,
            'datos'=>$denuncia,
        ]);

    }

    public function verificarSiEsFamoso($urlImagen){
        $cliente = new RekognitionClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' =>'latest'
        ]);
        
        $result = $cliente->recognizeCelebrities([
            'Image' => [
                'Bytes' => file_get_contents($urlImagen),
            ],
        ]);
        
        $respuesta = $result['CelebrityFaces'];


       
        return  (count($respuesta) > 0) ? true : false;

    }


    public function denunciasAceptadas(){
        $denuncias = Denuncia::where('estado',2)->get();
        $year = Carbon::now()->year;

            foreach($denuncias as $denuncia){
                $datos=Nacionalidad::find($denuncia->nacionalidad_id);
                $denuncia->nacionalidad_code=$datos->code_icon;
                $array = explode("-", $denuncia->fecha_nacimiento);
                
                $jsonString = $denuncia->ubicacion;
                $objetoPHP = json_decode($jsonString);
            
                $denuncia->latitude=$objetoPHP->latitude;
                $denuncia->longitude=$objetoPHP->longitude;
                

                $denuncia->edad = $year-$array[0];
                $datos = Documento::find($denuncia->documento_id);
                $denuncia->documento_id=$datos->foto;
                $datos = Idioma::find($denuncia->idioma_id);
                $denuncia->idioma_id =$datos->nombre;
                $denuncia->estado = $denuncia->estado_descripcion;
                $datos = Color::find($denuncia->color_ojos);
                $denuncia->color_ojos = $datos->nombre;
                $datos = Color::find($denuncia->color_cabello);
                $denuncia->color_cabello = $datos->nombre;
                $fotosDeLaDenuncia = Fotos::where('denuncia_id','=',$denuncia->id)->get();
                $sw=true;
                foreach ($fotosDeLaDenuncia as $foto) {
                    $urlFoto = $foto['foto'];
                    if($sw){
                        $denuncia->imagen1=$urlFoto;
                        $sw=false;
                    }else{
                        $denuncia->imagen2=$urlFoto;
                    }
                 }       
    
            }
         
        return response()->json([
            'res'=>true,
            'datos'=>$denuncias,
        ]);

    }
    /**
     * Display the specified resource.
     */
    public function show(Denuncia $denuncia)
    {
        $fotos = Fotos::where('denuncia_id',$denuncia->id)->get();
        $documento = Documento::where('id',$denuncia->documento_id)->first();
        $colores = Color::get();
        return view('show-denuncia',compact('fotos','documento','denuncia','colores'));
    }



    public function actualizarEstado(Request $request,Denuncia $denuncia){
        
        $denuncia->update([
            'estado'=>$request['estado']
        ]);

        $id = $denucia->user_id;
        $devices = Device::where('user_id',$id)->get();

        $messages = [
            new ExpoMessage([
                'title' => 'Title 2',
                'body' => 'Su Denuncia fue cambiada de estado',
            ]),
        ];
        $defaultRecipients = [];
        foreach($devices as $device){
            $defaultRecipients[]=$device->token;
            
        }
        
        
        (new Expo)->send($messages)->to($defaultRecipients)->push();

       return  redirect()->route('home');
    }


    public function denunciasFiltradas($filtro_id){

        switch ($filtro_id) {
            case 0:                         // Recientes "DIA ACTUAL"
                $denuncias = Denuncia::whereDate('created_at', today())->where('estado', 2)
                ->get();
                break;
            case 1:                         // Antiguos "MAS DE UN MES"
                $fechaInicio = Carbon::now()->startOfMonth()->toDateString(); // Primer día del mes actual
                $denuncias = Denuncia::where('estado', 2)
                    ->whereDate('created_at', '>=', $fechaInicio)
                    ->get();
                break;
            case 2:                         // 1 SEMANA
                $fechaInicio = Carbon::now()->subDays(7)->toDateString(); 
                $fechaFin = Carbon::now()->toDateString(); 
                $denuncias = Denuncia::where('estado', 2)
                                    ->whereDate('created_at', '>=', $fechaInicio)
                                    ->whereDate('created_at', '<=', $fechaFin)
                                    ->get();
                break;
            case 3:                         // DEL MES
                $fechaInicio = Carbon::now()->subMonth()->startOfMonth()->toDateString();
                $fechaFin = Carbon::now()->subMonth()->endOfMonth()->toDateString();
                $denuncias = Denuncia::where('estado', 2)
                    ->whereDate('created_at', '>=', $fechaInicio)
                    ->whereDate('created_at', '<=', $fechaFin)
                    ->get();
                break;
            default:
                echo "Opción no reconocida";
                break;
        }
        
        return response()->json([
            'res'=>true,
            'datos'=>$denuncias,
        ]);

    }


    public function enviarLuxand(Request $request){

            
            $postData = array(
                "photo" => curl_file_create("./public/"),
                "gallery" => "Wedding 2022",
            );
            // Endpoint URL
            $url = "https://api.luxand.cloud/photo";

            // Request headers
            $headers = array(
                "token: " . "414d166cb82042b7b2aa8d68374fd749",
            );

            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);


            // Execute cURL session and get the response
            $response = curl_exec($ch);

            // Close cURL session
            curl_close($ch);

            // Print the response
           

                return response()->json([
                    'res'=>true,
                    'datos'=>$ch,
                ]);

// Print the response
        // $apiKey = '414d166cb82042b7b2aa8d68374fd749'; // Reemplaza con tu API Key de Luxand
        // $image = $request->file('imagen');

        // if ($image) {
        //     $client = new Client();

        //     try {
        //         $response = $client->request('POST', 'https://api.luxand.cloud/photo/store', [
        //             'headers' => [
        //                 'Authorization' => 'Token ' . $apiKey,
        //             ],
        //             'multipart' => [
        //                 [
        //                     'name' => 'photo',
        //                     'contents' => fopen($image->getPathname(), 'r'),
        //                     'filename' => $image->getClientOriginalName(),
        //                 ],
        //             ],
        //         ]);

        //         $result = $response->getBody()->getContents();

        //         // Maneja la respuesta de Luxand aquí
        //         return response()->json([
        //             'res'=>true,
        //             'datos'=>$result,
        //         ]);
        //     } catch (\Exception $e) {
        //         return $e->getMessage(); // Manejo de errores
        //     }
        // }

       

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


    public function escanearPersona(Request $request){
        $rutaImagen = $request->file('foto');   // aqui se debe obtener la foto del movil "FOTO POLICIAL"
            $name=time();
            $rutaDestino = sys_get_temp_dir().DIRECTORY_SEPARATOR."$name.jpg";
            rename($rutaImagen,$rutaDestino);

            $imagen1 =$this->subirCloudinary($rutaDestino);
            $urlImagen1 = $imagen1->getSecurePath();

            
             $similaridad = $this->compararFotografias($urlImagen1);  
                if($similaridad != 'nada'){
                    $datos=Nacionalidad::find($similaridad->nacionalidad_id);
                    $similaridad->nacionalidad_code=$datos->code_icon;
                    $similaridad->nacionalidad_id = $datos->nacionalidad;
                    $datos = Color::find($similaridad->color_ojos);
                    $similaridad->color_ojos = $datos->nombre;
                    $datos = Color::find($similaridad->color_cabello);
                    $similaridad->color_cabello = $datos->nombre;
                    $datos = Documento::find($similaridad->documento_id);
                    $similaridad->documento_id=$datos->foto;
                    
                    return response()->json([
                        'res'=>true,
                        'datos'=>$similaridad,
                    ]);
                } 
            return response()->json([
                'res'=>true,
                'datos' =>$similaridad,
            ]);


    }


    public function compararFotografias($imagen1){

        $cliente = new RekognitionClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' =>'latest'
        ]);

        $denuncias= Denuncia::get();
        $denunciaID;
            foreach($denuncias as $denuncia){
                $fotos = $denuncia->fotos;
               // dd($fotos);
                    foreach($fotos as $foto){
                        $fotoDenuncia = $foto['foto'];
                        $result = $cliente->compareFaces([
                            'SourceImage' => [
                                'Bytes' => file_get_contents($fotoDenuncia),
                            ],
                            'TargetImage' => [
                                'Bytes' => file_get_contents($imagen1),
                            ],
                        ]);
                        $faceMatches = $result['FaceMatches'];
                        if (!empty($faceMatches)) {
                            $similaridad = $faceMatches[0]['Similarity'];
                                if($similaridad>20){
                                    return $denuncia;
                                }
                            
                        }
                        
                    }
            }
        // Procesa la respuesta de Rekognition aquí
        return "nada";
    }

}
