<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use App\Repositories\MunicipioRepository;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    public $repository;
    public function __construct(MunicipioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->findAll();
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, Municipio $municipio)
    {
        //
    }

}
