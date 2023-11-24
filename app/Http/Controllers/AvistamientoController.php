<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avistamiento;
use App\Models\Denuncia;


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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // $fechaActual = now()->timestamp;
        // dd(now());

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
