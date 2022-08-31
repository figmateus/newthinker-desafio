<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'tb_municipio';
    public $timestamps = false;
    protected $primaryKey = 'codigo_municipio';
    protected $fillable = [
        'codigoUF',
        'nome',
        'status',
    ];

    public function Uf(): BelongsTo
    {
        return $this->belongsTo(Uf::class, 'codigoUF', 'codigo_uf');
    }
}
