<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Bairro extends Model
{
    use HasFactory;

    protected $table = 'tb_bairro';
    public $timestamps = false;
    protected $primaryKey = 'codigo_bairro';
    protected $fillable = [
        'codigo_municipio',
        'nome',
        'status',
    ];

    public function Municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'codigo_municipio', 'codigo_municipio');
    }
}
