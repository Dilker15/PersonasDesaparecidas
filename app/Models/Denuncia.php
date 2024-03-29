<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TipoCabello;
use App\Models\Documento;
use App\Models\Idioma;
use App\Models\Nacionalidad;
use App\Models\Telefono;
use App\Models\Avistamiento;
use App\Models\Fotos;
use Carbon\Carbon;


class Denuncia extends Model
{
    use HasFactory;

    protected $table = 'denuncias';

    protected $fillable = [
        'nombre',
        'apellidos',
        'genero',
        'fecha_nacimiento',
        'altura',
        'peso',
        'cicatriz',
        'tatuaje',
        'direccion',
        'color_cabello',
        'color_ojos',
        'fecha_desaparicion',
        'hora_desaparicion',
        'ultima_ropa_puesta',
        'ubicacion',
        'user_id',
        'nacionalidad_id',  // ya
        'documento_id',     // ya
        'idioma_id',        // ya
        'tipo_cabello_id',  // ya
        'estado',

    ];



    public function getEstadoDescripcionAttribute(){
       $estados = ["Pendiente","Aceptada","Rechazada"];
       return $estados[$this->attributes['estado']-1];
    
    }


    public function getFechaFormateadaAttribute(){
        $fecha = $this->attributes['created_at'];

        $fechaCarbon = new Carbon($fecha);

        $fechaFormateada = $fechaCarbon->format('d/m/Y');
        return $fechaFormateada;

    }



    public function getColorBadgetAttribute(){

            $colores = ['warning','success','danger'];
            return $colores[$this->attributes['estado']-1];

    }



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    
    public function nacionalidad(): HasOne
    {
        return $this->hasOne(Nacionalidad::class,'id', 'nacionalidad_id');
    }

   
    public function documento(): HasOne
    {
        return $this->hasOne(Documento::class);
    }


   
    public function idioma(): HasOne
    {
        return $this->hasOne(Idioma::class);
    }


    public function tipoCabello(): HasOne
    {
        return $this->hasOne(TipoCabello::class);
    }



    public function telefonos():HasMany
    {
        return $this->hasMany(Telefono::class);
    }



    public function fotos()
    {
        return $this->hasMany(Fotos::class);
    }


    public function avistamientos()
    {
        return $this->hasMany(Avistamiento::class);
    }





}
