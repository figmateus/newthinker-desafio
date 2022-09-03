<?php

namespace Tests\Feature;

use App\Models\Endereco;
use App\Models\Pessoa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PessoaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetPessoaEndpointWithoutFilter()
    {
        $pessoa = Pessoa::factory(3)
            ->has(Endereco::factory()->count(1), 'enderecos')
            ->create();

        $response = $this->getJson('/api/pessoa');

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($pessoa) {

            $json->hasAll(['data.0.codigoPessoa','data.0.nome', 'data.0.sobrenome', 'data.0.idade', 'data.0.login','data.0.senha','data.0.status']);

            $json->whereAllType([
                'data.0.codigoPessoa' => 'integer',
                'data.0.nome' => 'string',
                'data.0.sobrenome' => 'string',
                'data.0.idade' => 'integer',
                'data.0.login' => 'string',
                'data.0.senha' => 'string',
                'data.0.status' => 'integer',
            ]);

            $pessoa = $pessoa->first();
            $json->whereAll([
                'data.0.codigoPessoa' => $pessoa->codigo_pessoa,
                'data.0.nome' => $pessoa->nome,
                'data.0.sobrenome' => $pessoa->sobrenome,
                'data.0.idade' => $pessoa->idade,
                'data.0.login' => $pessoa->login,
                'data.0.senha' => $pessoa->senha,
                'data.0.status' => $pessoa->status,
            ]);
        });
    }

    public function testGetPessoaEndpointWithFilterByLogin()
    {
        $pessoa = Pessoa::factory(1)
            ->has(Endereco::factory()->count(1), 'enderecos')
            ->createOne();
        $response = $this->getJson('/api/pessoa?login=' . $pessoa->login);
//        dd($response);
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) use ($pessoa) {

            $json->hasAll(['data.codigoPessoa','data.nome', 'data.sobrenome', 'data.idade', 'data.login','data.senha','data.status', 'data.enderecos']);

            $json->whereAllType([
                'data.codigoPessoa' => 'integer',
                'data.nome' => 'string',
                'data.sobrenome' => 'string',
                'data.idade' => 'integer',
                'data.login' => 'string',
                'data.senha' => 'string',
                'data.status' => 'integer',
                'data.enderecos' => 'array'
            ]);

            $json->whereAll([
                'data.codigoPessoa' => $pessoa->codigo_pessoa,
                'data.nome' => $pessoa->nome,
                'data.sobrenome' => $pessoa->sobrenome,
                'data.idade' => $pessoa->idade,
                'data.login' => $pessoa->login,
                'data.senha' => $pessoa->senha,
                'data.status' => $pessoa->status,
                'data.enderecos' => $pessoa->enderecos
            ]);
        });
    }

    public function testGetPessoaEndpointWithFilterByStatus()
    {
        $pessoa = Pessoa::factory(4)
            ->has(Endereco::factory()->count(1), 'enderecos')
            ->create();
        $response = $this->getJson('/api/pessoa?status=' . $pessoa[0]->status);

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($pessoa) {

            $json->hasAll(['data.0.codigoPessoa','data.0.nome', 'data.0.sobrenome', 'data.0.idade', 'data.0.login','data.0.senha','data.0.status', 'data.0.enderecos']);

            $json->whereAllType([
                'data.0.codigoPessoa' => 'integer',
                'data.0.nome' => 'string',
                'data.0.sobrenome' => 'string',
                'data.0.idade' => 'integer',
                'data.0.login' => 'string',
                'data.0.senha' => 'string',
                'data.0.status' => 'integer',
                'data.0.enderecos' => 'array'
            ]);

            $json->whereAll([
                'data.0.codigoPessoa' => $pessoa[0]->codigo_pessoa,
                'data.0.nome' => $pessoa[0]->nome,
                'data.0.sobrenome' => $pessoa[0]->sobrenome,
                'data.0.idade' => $pessoa[0]->idade,
                'data.0.login' => $pessoa[0]->login,
                'data.0.senha' => $pessoa[0]->senha,
                'data.0.status' => $pessoa[0]->status,
                'data.0.enderecos' => $pessoa[0]->enderecos
            ]);
        });
    }

    public function testGetPessoaEndpointWithFilterByCodigo()
    {
        $pessoa = Pessoa::factory(4)
            ->has(Endereco::factory()->count(1), 'enderecos')
            ->create();

        $response = $this->getJson('/api/pessoa?codigoPessoa=' . $pessoa[0]->codigo_pessoa);
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) use ($pessoa) {

        $json->hasAll(['data.codigoPessoa','data.nome', 'data.sobrenome', 'data.idade', 'data.login','data.senha','data.status', 'data.enderecos']);

            $json->whereAllType([
                'data.codigoPessoa' => 'integer',
                'data.nome' => 'string',
                'data.sobrenome' => 'string',
                'data.idade' => 'integer',
                'data.login' => 'string',
                'data.senha' => 'string',
                'data.status' => 'integer',
                'data.enderecos' => 'array'
            ]);

            $json->whereAll([
                'data.codigoPessoa' => $pessoa[0]->codigo_pessoa,
                'data.nome' => $pessoa[0]->nome,
                'data.sobrenome' => $pessoa[0]->sobrenome,
                'data.idade' => $pessoa[0]->idade,
                'data.login' => $pessoa[0]->login,
                'data.senha' => $pessoa[0]->senha,
                'data.status' => $pessoa[0]->status,
                'data.enderecos' => $pessoa[0]->enderecos
            ]);
        });
    }

    public function testGetPessoaEndpointWithFilterByCodigoAndStatus()
    {
        $pessoa = Pessoa::factory(4)
            ->has(Endereco::factory()->count(1), 'enderecos')
            ->create();

        $response = $this->getJson('/api/pessoa?codigoPessoa=' . $pessoa[0]->codigo_pessoa . '&status=' . $pessoa[0]->status);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($pessoa) {

            $json->hasAll(['data.0.codigoPessoa','data.0.nome', 'data.0.sobrenome', 'data.0.idade', 'data.0.login','data.0.senha','data.0.status', 'data.0.enderecos']);

            $json->whereAllType([
                'data.0.codigoPessoa' => 'integer',
                'data.0.nome' => 'string',
                'data.0.sobrenome' => 'string',
                'data.0.idade' => 'integer',
                'data.0.login' => 'string',
                'data.0.senha' => 'string',
                'data.0.status' => 'integer',
                'data.0.enderecos' => 'array'
            ]);

            $json->whereAll([
                'data.0.codigoPessoa' => $pessoa[0]->codigo_pessoa,
                'data.0.nome' => $pessoa[0]->nome,
                'data.0.sobrenome' => $pessoa[0]->sobrenome,
                'data.0.idade' => $pessoa[0]->idade,
                'data.0.login' => $pessoa[0]->login,
                'data.0.senha' => $pessoa[0]->senha,
                'data.0.status' => $pessoa[0]->status,
                'data.0.enderecos' => $pessoa[0]->enderecos
            ]);
        });
    }

    public function testGetPessoaEndpointShouldFilterByStatusByCodigoAndLogin()
    {
        $pessoa = Pessoa::factory(4)
            ->has(Endereco::factory()->count(1), 'enderecos')
            ->create();
        $response = $this->getJson('/api/pessoa?status='.$pessoa[0]->status.'&codigoPessoa='.$pessoa[0]->codigo_pessoa.'&login='.$pessoa[0]->login);

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($pessoa) {

            $json->hasAll(['data.codigoPessoa','data.nome', 'data.sobrenome', 'data.idade', 'data.login','data.senha','data.status', 'data.enderecos']);

            $json->whereAllType([
                'data.codigoPessoa' => 'integer',
                'data.nome' => 'string',
                'data.sobrenome' => 'string',
                'data.idade' => 'integer',
                'data.login' => 'string',
                'data.senha' => 'string',
                'data.status' => 'integer',
                'data.enderecos' => 'array'
            ]);

            $json->whereAll([
                'data.codigoPessoa' => $pessoa[0]->codigo_pessoa,
                'data.nome' => $pessoa[0]->nome,
                'data.sobrenome' => $pessoa[0]->sobrenome,
                'data.idade' => $pessoa[0]->idade,
                'data.login' => $pessoa[0]->login,
                'data.senha' => $pessoa[0]->senha,
                'data.status' => $pessoa[0]->status,
                'data.enderecos' => $pessoa[0]->enderecos
            ]);
        });
    }

    public function testGetPessoaEndpointShouldReturnEmptyJsonWhenDontFoundPessoa()
    {
        $response = $this->getJson('/api/pessoa?codigoPessoa=10');
        $response->assertStatus(404);
        $response->assertJson([]);
    }

    public function testPostPessoaEndpoint()
    {
        $pessoa = Pessoa::factory(1)
            ->has(Endereco::factory()->count(1), 'enderecos')
            ->makeOne();
        dd($pessoa);

        $response = $this->postJson('/api/pessoa', $pessoa);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tb_bairro', [
            'codigo_municipio' => $pessoa['codigo_municipio'],
            'nome' => $pessoa['nome'],
            'status' => $pessoa['status'],
        ]);

        $response->assertJson(['mensagem', 'Pessoa cadastrada com sucesso.']);
    }
//
//    public function testPostPessoaShouldValidateWhenTryCreateAInvalidPessoa()
//    {
//        $pessoa = Pessoa::factory(1)->createOne();
//
//        $payload = [
//            'codigo_bairro' => $pessoa->codigo_bairro,
//            'nome' => '',
//            'status' => 1,
//        ];
//        $response = $this->postJson('/api/pessoa', $payload);
//
//        $response->assertStatus(422);
//
//        $response->assertJson(function (AssertableJson $json) {
//
//            $json->hasAll(['mensagem']);
//
//        });
//    }

//    public function testPutPessoaEndpoint()
//    {
//        $pessoa = Pessoa::factory(1)->createOne();
//
//        $payload = [
//            'codigo_municipio' => $pessoa->codigo_municipio,
//            'nome' =>"Itapetinga",
//            'status' => 1
//        ];
//
//        $response = $this->putJson('/api/pessoa/'. $pessoa->codigo_bairro, $payload);
//
//        $response->assertStatus(200);
//
//        $this->assertDatabaseHas('tb_bairro',[
//            'codigo_municipio' => $payload['codigo_municipio'],
//            'nome' => $payload['nome'],
//            'status' => $payload['status'],
//        ]);
//        $response->assertJson(function (AssertableJson $json) use ($payload){
//
//            $json->hasAll(['0.codigo_bairro', '0.codigo_municipio', '0.nome', '0.status']);
//
//            $json->whereAll([
//                '0.codigo_municipio' => $payload['codigo_municipio'],
//                '0.nome' => $payload['nome'],
//                '0.status' => $payload['status'],
//            ]);
//        });
//    }
//
//    public function testPutPessoaShouldReturnErrorWhenDontFindPessoa()
//    {
//        $pessoa = Pessoa::factory(1)->createOne();
//
//        $payload = [
//            'codigo_municipio' => $pessoa->codigo_municipio,
//            'nome' =>"Itapetinga",
//            'status' => 1
//        ];
//
//        $response = $this->putJson('/api/pessoa/999', $payload);
//
//        $response->assertStatus(404);
//
//        $response->assertJson(['mensagem' => 'Pessoa não encontrado na base de dados.']);
//    }
}
