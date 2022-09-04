<?php

namespace App\Services;

use App\Http\Resources\PessoaResource;
use App\Repositories\PessoaRepository;
use SebastianBergmann\Diff\Exception;

class PessoaService
{

    protected $Repository;

    public function __construct(PessoaRepository $Repository)
    {
        $this->Repository = $Repository;
    }
    public function FilterPessoa($data)
    {

        if (!$data) {
            $pessoa = $this->Repository->findAll();
            if(!$pessoa){
                return response()->json([]);
            }
            return PessoaResource::collection($pessoa);
        }

        if(isset($data['login'])){
            $pessoa = $this->Repository->findByLogin($data['login']);
            if(!$pessoa){
                return response()->json([],404);
            }
            return new PessoaResource($pessoa);
        }

        if(isset($data['status'])){
            $pessoa = $this->Repository->findByStatus($data['status']);
            if(!$pessoa){
                return response()->json([],404);
            }
            return PessoaResource::collection($pessoa);
        }

        if(isset($data['codigoPessoa'])){
            $pessoa = $this->Repository->findByCodigo($data['codigoPessoa']);
            if(!$pessoa){
                return response()->json([],404);
            }
            return new PessoaResource($pessoa);
        }

        if(isset($data['codigoPessoa']) && isset($data['status'])){
            $pessoa = $this->Repository->findByCodigoAndStatus($data);
            return new PessoaResource($pessoa);
        }

        if(isset($data['status']) && isset($data['codigoPessoa']) && isset($data['login'])){
            $pessoa = $this->Repository->findByStatusByCodigoAndLogin($data);
            if(!$pessoa) {
                return response()->json([],404);
            }
            return new PessoaResource($pessoa);
        }
    }

    public function createPessoa($data)
    {
        $response =  $this->Repository->StorePessoa($data);
        if($response === true){
            return response()->json(['mensagem' => 'Pessoa Cadastrada com sucesso.'],201);
        }
        return response()->json(['mensagem'=> $response]);
    }

    public function updatePessoa($codigoPessoa, $data)
    {
        $response = $this->Repository->UpdatePessoa($codigoPessoa, $data);
        return response()->json(['mensagem' => $response]);
//        if($response === true) {
//            return $this->Repository->findAll();
//        }
//        return response()->json(['mensagem' => 'Não foi possivel alterar a Pessoa.'],503);
    }
}
