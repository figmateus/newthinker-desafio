<?php

namespace App\Http\Controllers;

use App\Http\Requests\MunicipioRequest;
use App\Models\Municipio;
use App\Services\MunicipioService;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    public $service;
    public function __construct(MunicipioService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return $this->service->filterMunicipio($request->all());
    }

    public function store(MunicipioRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(int $id, Request $request)
    {
        return $this->service->update($id, $request->all());
    }

}
