<?php

namespace App\Repositories;

use App\Models\Bairro;

class BairroRepository
{
    private $model;
    public function __construct()
    {
        $this->model = new Bairro();
    }

    public function findAll()
    {
        return $this->model->all();
    }

    public function FilterByName($data)
    {
        return $this->model->whereNome($data)->first();
    }

    public function FilterByCodigo($data)
    {
        return $this->model->whereCodigoBairro($data)->first();
    }

    public function FilterByCodigoAndName($data)
    {
        return $this->model->whereCodigoBairro($data['codigo_bairro'])
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
