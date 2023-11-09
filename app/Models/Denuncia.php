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
use App\Models\Foto;


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
        'nacionalidad_id',
        'documento_id',
        'idioma_id',
        'tipo_cabello_id',
        'estado',

    ];




    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    
    public function nacionalidad(): HasOne
    {
        return $this->hasOne(Nacionalidad::class);
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



    public function fotos():HasMany
    {
        return $this->hasMany(Foto::class);
    }



}
