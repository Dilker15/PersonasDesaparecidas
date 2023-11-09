<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnfermedadDenuncia extends Model
{
    use HasFactory;

    protected $table = 'enfermedades_denuncia';

    protected $fillable = [
        'id_denuncia',
        'id_enfermedad',
    ];

    
}
