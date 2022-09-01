<?php

namespace App\Services;

use App\Repositories\MunicipioRepository;

class MunicipioService
{

    protected $Repository;

    public function __construct(MunicipioRepository $Repository)
    {
        $this->Repository = $Repository;
    }

    public function filterMunicipio($data)
    {
        if (!$data) {
            return response()->json($this->Repository->findAll());
        }

        if (isset($data['codigoMunicipio'])) {

            $municipio = $this->Repository->FilterByCodigo($data['codigoMunicipio']);
            if (!$municipio) {
                return response()->json([], 404);
            }
            return response()->json($municipio, 200);
        }

        if (isset($data['nome'])) {
            $municipio = $this->Repository->FilterByName($data['nome']);
            if (!$municipio) {
                return response()->json([], 404);
            }
            return response()->json($municipio, 200);
        }

        if (isset($data['status'])) {
            $municipio = $this->Repository->FilterByStatus($data['status']);
            if (!$municipio) {
                return response()->json([], 404);
            }
            return response()->json($municipio, 200);
        }

        if (isset($data['codigo_uf']) && isset($data['nome'])) {
            $uf = $this->Repository->FilterByCodigoAndName($data);
            if (!$uf) {
                return response()->json([], 404);
            }
            return response()->json($uf, 200);
        }
    }

    public function update($codigoMunicipio, $data)
    {

        $municipio = $this->Repository->FilterByCodigo($codigoMunicipio);

        if (!$municipio) {
            return response()->json(['mensagem' => 'Municipio não encontrado na base de dados.'], 404);
        }

        $municipio->codigo_uf = $data['codigo_uf'];
        $municipio->nome = $data['nome'];
        $municipio->status = $data['status'];
        $municipio->save();
        $municipios = $this->Repository->findAll();
        return response()->json($municipios);
    }

    public function create($data)
    {
        $municipios = $this->Repository->findAll();
        foreach ($municipios as $municipio) {
            if ($municipio->nome == $data['nome']) {
                return response()->json(['mensagem', 'Não foi possível cadastrar, pois já existe um registro de Municipio com o mesmo nome cadastrado.'], 400);
            }
        }
        if ($this->Repository->create($data)) {
            return response()->json(['mensagem', 'Municipio cadastrada com sucesso.'], 201);
        }
    }
}
