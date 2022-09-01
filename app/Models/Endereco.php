<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Endereco extends Model
{
    use HasFactory;

    protected $table = 'tb_endereco';
    public $timestamps = false;
    protected $primaryKey = 'codigo_endereco';
    protected $fillable = [
        'codigo_pessoa',
        'codigo_bairro',
        'nome_rua',
        'numero',
        'complemento',
        'cep',
    ];

    public function Pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'codigo_pessoa', 'codigo_pessoa');
    }
}
