<?php

namespace App\Http\Controllers;

use App\Http\Requests\PessoaRequest;
use App\Services\PessoaService;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    public $service;

    public function __construct(PessoaService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return $this->service->FilterPessoa($request->all());
    }

    public function store(PessoaRequest $request)
    {
        return $this->service->createPessoa($request->all());
    }
}
