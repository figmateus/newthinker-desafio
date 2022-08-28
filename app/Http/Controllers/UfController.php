<?php

namespace App\Http\Controllers;
use App\Models\Uf;
use Illuminate\Http\Request;

class UfController
{
    public function __construct(Private Uf $uf)
    {
    }

    public function index(){
        return response()->json($this->uf->all());
    }

    public function show(int $id)
    {
        $uf = $this->uf->find($id);
        return response()->json($uf);
    }

    public function store(Request $request)
    {
        $uf = $this->uf->create($request->all());

        return response()->json($uf, 201);
    }

}
