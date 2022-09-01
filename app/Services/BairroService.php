<?php

namespace App\Services;

use App\Repositories\BairroRepository;

class BairroService
{
    protected $Repository;

    public function __construct(BairroRepository $Repository)
    {
        $this->Repository = $Repository;
    }

    public function filterBairro($data)
    {
        if (!$data) {
            return response()->json($this->Repository->findAll());
        }

        if (isset($data['codigoBairro'])) {

            $bairro = $this->Repository->FilterByCodigo($data['codigoBairro']);
            if (!$bairro) {
                return response()->json([], 404);
            }
            return response()->json($bairro, 200);
        }

        if (isset($data['nome'])) {
            $bairro = $this->Repository->FilterByName($data['nome']);
            if (!$bairro) {
                return response()->json([], 404);
            }
            return response()->json($bairro, 200);
        }

        if (isset($data['status'])) {
            $bairro = $this->Repository->FilterByStatus($data['status']);
            if (!$bairro) {
                return response()->json([], 404);
            }
            return response()->json($bairro, 200);
        }

        if (isset($data['codigo_municipio']) && isset($data['nome'])) {
            $uf = $this->Repository->FilterByCodigoAndName($data);
            if (!$uf) {
                return response()->json([], 404);
            }
            return response()->json($uf, 200);
        }
    }

    public function update($codigoBairro, $data)
    {

        $bairro = $this->Repository->FilterByCodigo($codigoBairro);

        if (!$bairro) {
            return response()->json(['mensagem' => 'Bairro não encontrado na base de dados.'], 404);
        }

        $bairro->codigo_municipio = $data['codigo_municipio'];
        $bairro->nome = $data['nome'];
        $bairro->status = $data['status'];
        $bairro->save();
        $bairros = $this->Repository->findAll();
        return response()->json($bairros);
    }

    public function create($data)
    {
        $bairros = $this->Repository->findAll();
        foreach ($bairros as $bairro) {
            if ($bairro->nome == $data['nome']) {
                return response()->json(['mensagem', 'Não foi possível cadastrar, pois já existe um registro de Bairro com o mesmo nome cadastrado.'], 400);
            }
        }
        if ($this->Repository->create($data)) {
            return response()->json(['mensagem', 'Bairro cadastrada com sucesso.'], 201);
        }
    }
}
