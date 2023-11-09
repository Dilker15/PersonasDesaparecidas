<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCabello extends Model
{
    use HasFactory;

    protected $table = 'tipos_cabello';

    protected $fillable = [
        'nombre',
    ];
}
