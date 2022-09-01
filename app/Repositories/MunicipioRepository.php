<?php

namespace App\Repositories;
use App\Models\Municipio;
class MunicipioRepository
{
    private $model;
    public function __construct()
    {
        $this->model = new Municipio();
    }

    public function findAll()
    {
        return Municipio::all();
    }

    public function FilterByName($data)
    {
        return $this->model->whereNome($data)->first();
    }

    public function FilterByCodigo($data)
    {
        return $this->model->whereCodigoMunicipio($data)->first();
    }

    public function FilterByCodigoAndName($data)
    {
        return $this->model->whereCodigoMunicipio($data['codigo_uf'])
            ->whereNome($data['nome'])->first();
    }

    public function FilterByStatus($data)
    {
        return $this->model->whereStatus($data)->get();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
