<?php

namespace App\Repositories;
use App\Models\Municipio;
class MunicipioRepository
{

    public function findAll()
    {
        return Municipio::all();
    }
}
