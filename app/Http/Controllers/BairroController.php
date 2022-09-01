<?php

namespace App\Http\Controllers;
use App\Http\Requests\BairroRequest;
use App\Services\BairroService;
use Illuminate\Http\Request;
class BairroController
{
    public $service;
    public function __construct(BairroService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request){
        return $this->service->filterBairro($request->all());
    }

    public function store(BairroRequest $request)
    {
        return $this->service->create($request->all());
    }

    public function update($codigoBairro, Request $request)
    {
        return $this->service->update($codigoBairro, $request->all());
    }
}
