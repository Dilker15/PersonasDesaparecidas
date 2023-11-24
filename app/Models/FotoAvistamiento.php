<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Avistamiento;

class FotoAvistamiento extends Model
{
    use HasFactory;

    protected $table = 'foto_avistamientos';

    protected $fillable =[
        'foto',
        'public_id',
        'avistamiento_id',
    ];



    public function avistamiento(): BelongsTo
    {
        return $this->belongsTo(Avistamiento::class);
    }
}
