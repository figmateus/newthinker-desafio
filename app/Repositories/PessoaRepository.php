<?php

namespace App\Repositories;

use App\Http\Resources\PessoaResource;
use App\Models\Endereco;
use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;
class PessoaRepository
{
    private $model;
    public function __construct()
    {
        $this->model = new Pessoa();
    }

    public function findAll()
    {
        return $this->model->all();
    }

    public function findByLogin($data)
    {
        return Pessoa::with('enderecos')->whereLogin($data)->first();
    }

    public function findByStatus($data)
    {
        return Pessoa::with('enderecos')->whereStatus($data)->get();
    }

    public function findByCodigo($data)
    {
        return Pessoa::with('enderecos')->whereCodigoPessoa($data)->first();
    }

    public function findByCodigoAndStatus($data)
    {
        return $this->model->with('enderecos')
            ->where('codigo_pessoa', $data['codigoPessoa'])
            ->where('status', $data['status'])
            ->first();
    }

    public function findByStatusByCodigoAndLogin($data)
    {
        return $this->model->with('enderecos')
            ->where('status', $data['status'])
            ->where('codigo_pessoa', $data['codigoPessoa'])
            ->where('login', $data['login'])
            ->first();
    }

    public function StorePessoa($data)
    {
        try{

            $pessoa = $this->model->create([
                'nome' => $data['nome'],
                'sobrenome' => $data['sobrenome'],
                'idade' => $data['idade'],
                'login' => $data['login'],
                'senha' => $data['senha'],
                'status' => $data['status'],
            ]);

            foreach ($data['enderecos'] as $e){
                $endereco = Endereco::create([
                    'codigo_pessoa' => $pessoa->codigo_pessoa,
                    'codigo_bairro' => $e['codigoBairro'],
                    'nome_rua' => $e['nomeRua'],
                    'numero' => $e['numero'],
                    'complemento' => $e['complemento'],
                    'cep' => $e['cep']
                ]);
                $pessoa->enderecos()->save($endereco);
                $pessoa->refresh();
            }


        return true;
        }catch (\Exception $e){
           return throw new \Exception($e->getMessage());
        }

    }

    public function UpdatePessoa($codigoPessoa, $data)
    {
        try{
            $pessoa = $this->model->with('enderecos')->find($codigoPessoa);

            foreach ($data['enderecos'] as $endereco){
                foreach ($pessoa->enderecos as $e) {
                    if(!isset($endereco->codigoEndereco)){
                        $pessoa->enderecos()->saveMany([
                            new Endereco([
                                'codigo_pessoa' => $pessoa->codigo_pessoa,
                                'codigo_bairro' => $endereco['codigoBairro'],
                                'nome_rua' => $endereco['nomeRua'],
                                'numero' => $endereco['numero'],
                                'complemento' => $endereco['complemento'],
                                'cep' => $endereco['cep']

                            ]),
                        ]);
                    }
                    if (isset($endereco['codigoEndereco']) &&
                        $endereco['codigoEndereco'] == $e->codigo_endereco) {
                        continue;
                    }else{
                        $e->delete();
                    }
//                    $pessoa->enderecos()->Create([
//                        'codigo_endereco' => $endereco['codigoEndereco'],
//                        'codigo_pessoa' => $endereco['codigoPessoa'],
//                        'codigo_bairro' => $endereco['codigoBairro'],
//                        'nome_rua' => $endereco['nomeRua'],
//                        'numero' => $endereco['numero'],
//                        'complemento' => $endereco['complemento'],
//                        'cep' => $endereco['cep'],
//                    ]);
                }


            }
        }catch (\Exception $e){
            return throw new \Exception($e->getMessage());
        }


    }
//        }
//        try{
//            $pessoa->nome
//        }
//        dd($pessoa);
}
