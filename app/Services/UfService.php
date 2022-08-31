<?php

namespace App\Services;

use App\Repositories\UfRepository;

class UfService

{
    protected $UfRepository;
    public function __construct(UfRepository $UfRepository)
    {
        $this->UfRepository = $UfRepository;
    }

    public function filterUf($data)
    {
        if(!$data){
            return response()->json($this->UfRepository->findALl());
        }

        if(isset($data['sigla'])){

            $uf = $this->UfRepository->FilterBySigla($data['sigla']);
            if(!$uf){
                return response()->json([],404);
            }
            return response()->json($uf,200);
        }

        if(isset($data['nome'])){
            $uf = $this->UfRepository->FilterByName($data['nome']);
            if(!$uf){
                return response()->json([],404);
            }
            return response()->json($uf,200);
        }

        if(isset($data['codigoUF']) && isset($data['nome'])){
            $uf = $this->UfRepository->FilterByCodigoAndName($data);
            if(!$uf){
                return response()->json([],404);
            }
            return response()->json($uf,200);
        }

        if(isset($data['codigoUF']) && isset($data['nome']) && isset($data['sigla'])){
            $uf = $this->repository->FilterByCodigoNameAndFilter($data);
            if(!$uf){
                return response()->json([],404);
            }
            return response()->json($uf,200);
        }
    }

    public function update($codigoUF, $data)
    {

        $uf = $this->UfRepository->findByCodigo($codigoUF);

        if(!$uf){
            return response()->json(['mensagem' => 'Uf não encontrado na base de dados.'],404);
        }

        $uf->sigla = $data['sigla'];
        $uf->nome = $data['nome'];
        $uf->status = $data['status'];
        $uf->save();
        $ufs = $this->UfRepository->findALl();
        return response()->json($ufs);
    }

    public function create($data)
    {
        $ufs = $this->UfRepository->findALl();
        foreach ($ufs as $uf){
            if($uf->sigla == $data['sigla']){
                return response()->json(['mensagem', 'Não foi possível cadastrar, pois já existe um registro de UF com a mesma sigla.'],400);
            }
        }
        if($this->UfRepository->create($data)){
            return response()->json(['mensagem', 'UF cadastrada com sucesso.'],201);
        }
    }
}

