<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pessoa extends Model
{
    use HasFactory;

    protected $table = 'tb_pessoa';
    public $timestamps = false;
    protected $primaryKey = 'codigo_pessoa';
    protected $fillable = [
        'nome',
        'sobrenome',
        'idade',
        'login',
        'senha',
        'status',
    ];

    public function endereco(): HasMany
    {
        return $this->hasMany(Endereco::class);
    }
}
