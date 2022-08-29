<?php

namespace App\Http\Controllers;
use App\Models\Uf;
use App\Repositories\UfRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UfController
{
    public $repository;
    public function __construct(Private Uf $uf, UfRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request){
        if(!$request->has('sigla') &&
            !$request->has('codigoUF') &&
            !$request->has('nome'))
        {
            return response()->json($this->uf->all());
        }

        if($request->has('sigla')){
            $sigla = $this->repository->FilterBySigla($request->sigla);

            if($sigla == null){
               return response()->json([]);
            }

           return $sigla;
        }

        if($request->has('nome')){
            $uf = $this->repository->FilterByName($request->nome);

            if($uf == null){
                return response()->json([]);
            }

            return $uf;
        }

        if($request->has('codigoUF') &&
        $request->has('nome')){
            $uf = $this->repository->FilterByCodigoAndName($request->all());

            if($uf == null){
                return response()->json([]);
            }

            return $uf;
        }

        if($request->has('codigoUF') &&
            $request->has('nome') &&
            $request->has('sigla')){

            $uf = $this->repository->FilterByCodigoNameAndFilter($request->all());

            if($uf == null){
                return response()->json([]);
            }

            return $uf;
        }
    }

    public function show(int $id)
    {
        $uf = $this->uf->find($id);
        if($uf === null){
            return response()->json(['message' => 'Uf não encontrada!'],404);
        }
        return response()->json($uf);
    }

    public function store(Request $request)
    {
        $uf = $this->uf->create($request->all());

        return response()->json($uf, 201);
    }

    public function update($codigoUF, Request $request)
    {
        return $this->repository->updateUf($codigoUF, $request->all());
    }
}
