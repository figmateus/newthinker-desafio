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

    public function findALl()
    {
        return $this->model->all();
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
        return Uf::whereCodigo_uf($data['codigoUF'])
            ->whereNome($data['nome'])->first();
    }

    public function FilterByCodigoNameAndFilter($data)
    {
        return Uf::whereHasCodigo_uf($data['codigoUF'])
            ->whereHasNome($data['nome'])
            ->whereHasSigla($data['sigla'])->first();
    }

    public function findByCodigo($codigoUF)
    {
        return Uf::where('codigo_uf', $codigoUF)->first();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
