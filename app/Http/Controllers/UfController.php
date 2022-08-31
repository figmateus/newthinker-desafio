<?php

namespace App\Http\Controllers;
use App\Http\Requests\UfRequest;
use App\Models\Uf;
use App\Repositories\UfRepository;
use App\Services\UfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UfController
{
    public $repository;
    public $service;
    public function __construct(Private Uf $uf,UfService $service, UfRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request){
        $response = $this->service->filterUf($request->all());
        return $response;
    }

    public function show(int $id)
    {
        $uf = $this->uf->find($id);
        if($uf === null){
            return response()->json(['message' => 'Uf não encontrada!'],404);
        }
        return response()->json($uf);
    }

    public function store(UfRequest $request)
    {
        return $this->service->create($request->all());
    }

    public function update($codigoUF, Request $request)
    {
        return $this->service->update($codigoUF, $request->all());
    }
}
