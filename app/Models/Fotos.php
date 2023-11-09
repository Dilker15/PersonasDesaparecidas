<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Denuncia;

class Fotos extends Model
{
    use HasFactory;

    protected $table ='fotos';

    protected $fillable = [
        'foto',
        'public_id',
        'secure_url',
        'denuncia_id'
    ];



    public function denuncia(): BelongsTo
    {
        return $this->belongsTo(Denuncia::class);
    }
}
