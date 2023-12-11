<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FotoAvistamiento;
use App\Models\Denuncia;
class Avistamiento extends Model
{
    use HasFactory;

    protected $table = 'avistamientos';
    protected $fillable = [
        'descripcion',
        'ubicacion',
        'hora',
        'fecha',
        'contacto',
        'denuncia_id',
        'user_id',
    ];


    public function fotos()
    {
        return $this->hasMany(FotoAvistamiento::class);
    }

    
    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class);
    }



}
