<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Denuncia;

class Telefonos extends Model
{
    use HasFactory;


    protected $table = 'telefonos';

    protected $fillable = [
        'numero',
        'denuncia_id',
    ];



    public function denuncia(): BelongsTo
    {
        return $this->belongsTo(Denuncia::class);
    }
}
