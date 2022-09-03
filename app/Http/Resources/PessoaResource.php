<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EnderecoResource;
class PessoaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'codigoPessoa' => $this->codigo_pessoa,
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'idade' => $this->idade,
            'login' => $this->login,
            'senha' => $this->senha,
            'status' => $this->status,
            'enderecos' => EnderecoResource::collection($this->whenLoaded('enderecos')),
//            'enderecos' => EnderecoResource::collection($this->enderecos)
        ];
    }
}
