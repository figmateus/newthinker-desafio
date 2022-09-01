<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'tb_municipio';
    public $timestamps = false;
    protected $primaryKey = 'codigo_municipio';
    protected $fillable = [
        'codigo_uf',
        'nome',
        'status',
    ];

    public function Uf(): BelongsTo
    {
        return $this->belongsTo(Uf::class, 'codigo_uf', 'codigo_uf');
    }

    public function bairro(): HasMany
    {
        return $this->hasMany(Bairro::class);
    }
}
