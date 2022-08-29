<?php

namespace App\Repositories;

use App\Models\Uf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UfRepository
{

    private $model;
    public function __construct()
    {
        $this->model = new Uf();
    }

    public function FilterBySigla($data)
    {
        return Uf::whereSigla($data)->first();
    }

    public function FilterByName($data)
    {
        return Uf::whereNome($data)->first();
    }

    public function FilterByCodigoAndName($data)
    {
        return DB::table('tb_uf')
            ->where('codigo_uf', $data['codigoUF'])
            ->where('nome', $data['nome'])
            ->get();
    }

    public function FilterByCodigoNameAndFilter($data)
    {
        return DB::table('tb_uf')
        ->where('codigo_uf', $data['codigoUF'])
        ->where('nome', $data['nome'])
        ->where('sigla', $data['sigla'])
        ->get();
    }

    public function updateUf($codigoUF, $body)
    {
        $uf = Uf::where('codigo_uf', $codigoUF)->first();
        if($uf == null){
            return response()->json(['mensagem' => 'Não foi possível alterar, pois já existe um registro de UF com a mesma sigla cadastrada.'],400);
        }

        $uf->sigla = $body['sigla'];
        $uf->nome = $body['nome'];
        $uf->status = $body['status'];
        $uf->save();

        return response()->json($uf);
    }
}
