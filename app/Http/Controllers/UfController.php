<?php

namespace App\Http\Controllers;
use App\Http\Requests\UfRequest;
use App\Services\UfService;
use Illuminate\Http\Request;

class UfController
{
    public $service;
    public function __construct(UfService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request){
        $response = $this->service->filterUf($request->all());
        return $response;
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
