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
        
            if (preg_match("/" . preg_quote($cadena_a_buscar, "/") . "/", $datos) && preg_match("/" . preg_quote($nombreDe, "/") . "/", $datos)) {
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
                                        'tipo_cabello_id'=>$request['tipo_cabello_id'],
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

                                    // $contactos = $request['contactos']; // request['contactos'] debe ser un array de minimo 1 numero o mas...
                                    
                                    // for($i=0;$i<count($contactos);$i++){
                                    //     Telefonos::create([
                                    //         'numero'=>$contactos[$i],
                                    //         'denuncia_id'=>$denuncia->id,
                                    //     ]);
                                    // }

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
                                            //'tipo_cabello_id'=>$request['tipo_cabello_id'], // numerico ID del tipocabello
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

            foreach($denuncias as $denuncia){
                $datos=Nacionalidad::find($denuncia->nacionalidad_id);
                $denuncia->nacionalidad_id=$datos->nacionalidad;
                $datos = Documento::find($denuncia->documento_id);
                $denuncia->documento_id=$datos->foto;
                $datos = Idioma::find($denuncia->idioma_id);
                $denuncia->idioma_id =$datos->nombre;
                $datos = TipoCabello::find($denuncia->tipo_cabello_id);
                $denuncia->tipo_cabello_id=$datos->nombre;
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

    public function verificarSiEsFamoso($urlImagen){
        // return response()->json([
        //     'res'=>$request['urlImagen'],
        // ]);
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

        $denuncias = Denuncia::where('estado',1)->get();
        
        foreach($denuncias as $denuncia){
            $fotosDeLaDenuncia = Fotos::where('denuncia_id',$denuncia->id)->get();
            $fotoDelDocumento = Documento::where('id',$denuncia->documento_id)->first();
            $denuncia->documento = $fotoDelDocumento->foto;
            $sw=true;
                foreach($fotosDeLaDenuncia as $foto){
                    if($sw){
                        $denuncia->imagen1 = $foto->foto;
                        $sw=false;
                    }else{
                        $denuncia->imagen2 = $foto->foto;
                    }

                }
        }
        
        return response()->json([
            'res' =>true,
            'datos'=>$denuncias,
        ],200);


    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
