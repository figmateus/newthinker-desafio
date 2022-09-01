<?php

namespace Tests\Feature;

use App\Models\Bairro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BairroControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetBairroEndpointWithoutFilter()
    {
        $bairros = Bairro::factory(3)->create();

        $response = $this->getJson('/api/bairro');

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($bairros) {

            $json->hasAll(['0.codigo_bairro', '0.codigo_municipio', '0.nome', '0.status']);

            $json->whereAllType([
                '0.codigo_bairro' => 'integer',
                '0.codigo_municipio' => 'integer',
                '0.nome' => 'string',
                '0.status' => 'integer',
            ]);

            $bairro = $bairros->first();
            $json->whereAll([
                '0.codigo_bairro' => $bairro->codigo_bairro,
                '0.codigo_municipio' => $bairro->codigo_municipio,
                '0.nome' => $bairro->nome,
                '0.status' => $bairro->status,
            ]);
        });
    }

    public function testGetBairroEndpointWithFilterByName()
    {
        $bairro = Bairro::factory(1)->createOne();
        $response = $this->getJson('/api/bairro?nome=' . $bairro->nome);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($bairro) {

            $json->hasAll(['codigo_municipio', 'codigo_bairro', 'nome', 'status']);

            $json->whereAllType([
                'codigo_municipio' => 'integer',
                'codigo_bairro' => 'integer',
                'nome' => 'string',
                'status' => 'integer',
            ]);

            $json->whereAll([
                'codigo_municipio' => $bairro->codigo_municipio,
                'codigo_bairro' => $bairro->codigo_bairro,
                'nome' => $bairro->nome,
                'status' => $bairro->status,
            ]);
        });
    }

    public function testGetBairroEndpointWithFilterByCodigo()
    {
        $bairro = Bairro::factory(1)->createOne();

        $response = $this->getJson('/api/bairro?codigoBairro=' . $bairro->codigo_bairro);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($bairro) {

            $json->hasAll(['codigo_municipio', 'codigo_bairro', 'nome', 'status']);

            $json->whereAllType([
                'codigo_bairro' => 'integer',
                'codigo_municipio' => 'integer',
                'nome' => 'string',
                'status' => 'integer',
            ]);

            $json->whereAll([
                'codigo_bairro' => $bairro->codigo_bairro,
                'codigo_municipio' => $bairro->codigo_municipio,
                'nome' => $bairro->nome,
                'status' => $bairro->status,
            ]);
        });
    }

    public function testGetBairroEndpointWithFilterByStatus()
    {
        $bairro = Bairro::factory(1)->createOne();

        $response = $this->getJson('/api/bairro?status=' . $bairro->status);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($bairro) {

            $json->hasAll(['0.codigo_municipio', '0.codigo_bairro', '0.nome', '0.status']);

            $json->whereAllType([
                '0.codigo_bairro' => 'integer',
                '0.codigo_municipio' => 'integer',
                '0.nome' => 'string',
                '0.status' => 'integer',
            ]);

            $json->whereAll([
                '0.codigo_bairro' => $bairro->codigo_bairro,
                '0.codigo_municipio' => $bairro->codigo_municipio,
                '0.nome' => $bairro->nome,
                '0.status' => $bairro->status,
            ]);
        });
    }

    public function testGetBairroEndpointWithFilterByCodigoAndName()
    {
        $bairro = Bairro::factory(1)->createOne();

        $response = $this->getJson('/api/bairro?codigoBairro=' . $bairro->codigo_bairro . '&nome=' . $bairro->nome);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($bairro) {

            $json->hasAll(['codigo_municipio', 'codigo_bairro', 'nome', 'status']);

            $json->whereAllType([
                'codigo_municipio' => 'integer',
                'codigo_bairro' => 'integer',
                'nome' => 'string',
                'status' => 'integer',
            ]);

            $json->whereAll([
                'codigo_municipio' => $bairro->codigo_municipio,
                'codigo_bairro' => $bairro->codigo_bairro,
                'nome' => $bairro->nome,
                'status' => $bairro->status,
            ]);
        });
    }

    public function testGetBairroEndpointShouldFilterByCodigoMunicipioCodigoBairroAndNome()
    {
        $bairro = Bairro::factory(1)->createOne();
        $response = $this->getJson('/api/bairro?codigoMunicipio='.$bairro->codigo_municipio.'&codigoBairro='.$bairro->codigo_bairro.'&nome='.$bairro->nome);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($bairro) {

            $json->hasAll(['codigo_municipio', 'codigo_bairro', 'nome', 'status']);

            $json->whereAllType([
                'codigo_municipio' => 'integer',
                'codigo_bairro' => 'integer',
                'nome' => 'string',
                'status' => 'integer',
            ]);

            $json->whereAll([
                'codigo_municipio' => $bairro->codigo_municipio,
                'codigo_bairro' => $bairro->codigo_bairro,
                'nome' => $bairro->nome,
                'status' => $bairro->status,
            ]);
        });
    }

    public function testGetBairroEndpointShouldReturnEmptyJsonWhenDontFoundBairro()
    {
        $response = $this->getJson('/api/bairro?nome=BairroNulo');
        $response->assertStatus(404);
        $response->assertJson([]);
    }

    public function testPostBairroEndpoint()
    {
        $bairro = Bairro::factory(1)->makeOne()->toArray();

        $response = $this->postJson('/api/bairro', $bairro);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tb_bairro', [
            'codigo_municipio' => $bairro['codigo_municipio'],
            'nome' => $bairro['nome'],
            'status' => $bairro['status'],
        ]);

        $response->assertJson(['mensagem', 'Bairro cadastrada com sucesso.']);
    }

    public function testPostBairroShouldValidateWhenTryCreateAInvalidBairro()
    {
        $bairro = Bairro::factory(1)->createOne();

        $payload = [
            'codigo_bairro' => $bairro->codigo_bairro,
            'nome' => '',
            'status' => 1,
        ];
        $response = $this->postJson('/api/bairro', $payload);

        $response->assertStatus(422);

        $response->assertJson(function (AssertableJson $json) {

            $json->hasAll(['mensagem']);

        });
    }

    public function testPutBairroEndpoint()
    {
        $bairro = Bairro::factory(1)->createOne();

        $payload = [
            'codigo_municipio' => $bairro->codigo_municipio,
            'nome' =>"Itapetinga",
            'status' => 1
        ];

        $response = $this->putJson('/api/bairro/'. $bairro->codigo_bairro, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tb_bairro',[
            'codigo_municipio' => $payload['codigo_municipio'],
            'nome' => $payload['nome'],
            'status' => $payload['status'],
        ]);
        $response->assertJson(function (AssertableJson $json) use ($payload){

            $json->hasAll(['0.codigo_bairro', '0.codigo_municipio', '0.nome', '0.status']);

            $json->whereAll([
                '0.codigo_municipio' => $payload['codigo_municipio'],
                '0.nome' => $payload['nome'],
                '0.status' => $payload['status'],
            ]);
        });
    }

    public function testPutBairroShouldReturnErrorWhenDontFindBairro()
    {
        $bairro = Bairro::factory(1)->createOne();

        $payload = [
            'codigo_municipio' => $bairro->codigo_municipio,
            'nome' =>"Itapetinga",
            'status' => 1
        ];

        $response = $this->putJson('/api/bairro/999', $payload);

        $response->assertStatus(404);

        $response->assertJson(['mensagem' => 'Bairro não encontrado na base de dados.']);
    }
}
