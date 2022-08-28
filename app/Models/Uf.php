<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    use HasFactory;
    protected $table = 'tb_uf';
    public $timestamps = false;
    protected $primaryKey = 'codigo_uf';
    protected $fillable = [
        'codigo_uf',
        'sigla',
        'nome',
        'status',
    ];
}
