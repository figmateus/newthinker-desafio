<?php
namespace Tests\Feature;

use App\Models\Uf;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Municipio;

class MunicipioControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetMunicipioEndpointWithoutFilter()
    {
        $municipios = Municipio::factory(3)->create();

        $response = $this->getJson('/api/municipio');

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($municipios) {

            $json->hasAll(['0.codigo_municipio', '0.codigo_uf', '0.nome', '0.status']);

            $json->whereAllType([
                '0.codigo_municipio' => 'integer',
                '0.codigo_uf' => 'integer',
                '0.nome' => 'string',
                '0.status' => 'integer',
            ]);

            $municipio = $municipios->first();
            $json->whereAll([
                '0.codigo_municipio' => $municipio->codigo_municipio,
                '0.codigo_uf' => $municipio->codigo_uf,
                '0.nome' => $municipio->nome,
                '0.status' => $municipio->status,
            ]);
        });
    }

    public function testGetMunicipioEndpointShouldReturnEmptyJsonWhenDontFoundMunicipio()
    {
        $response = $this->getJson('/api/municipio?nome=MunicipioNulo');
        $response->assertStatus(404);
        $response->assertJson([]);
    }

    public function testGetMunicipioEndpointShouldFilterByCodigoUfCodigoMunicipioAndNome()
    {
        $municipio = Municipio::factory(1)->createOne();
        $response = $this->getJson('/api/municipio?codigoUF='.$municipio->codigo_uf.'&codigoMunicipio='.$municipio->codigo_municipio.'&nome='.$municipio->nome);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($municipio) {

            $json->hasAll(['codigo_municipio', 'codigo_uf', 'nome', 'status']);

            $json->whereAllType([
                'codigo_municipio' => 'integer',
                'codigo_uf' => 'integer',
                'nome' => 'string',
                'status' => 'integer',
            ]);

            $json->whereAll([
                'codigo_municipio' => $municipio->codigo_municipio,
                'codigo_uf' => $municipio->codigo_uf,
                'nome' => $municipio->nome,
                'status' => $municipio->status,
            ]);
        });
    }
    public function testGetMunicipioEndpointWithFilterByName()
    {
        $municipio = Municipio::factory(1)->createOne();
        $response = $this->getJson('/api/municipio?nome=' . $municipio->nome);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($municipio) {

            $json->hasAll(['codigo_municipio', 'codigo_uf', 'nome', 'status']);

            $json->whereAllType([
                'codigo_municipio' => 'integer',
                'codigo_uf' => 'integer',
                'nome' => 'string',
                'status' => 'integer',
            ]);

            $json->whereAll([
                'codigo_municipio' => $municipio->codigo_municipio,
                'codigo_uf' => $municipio->codigo_uf,
                'nome' => $municipio->nome,
                'status' => $municipio->status,
            ]);
        });
    }

    public function testGetMunicipioEndpointWithFilterByCodigo()
    {
        $municipio = Municipio::factory(1)->createOne();

        $response = $this->getJson('/api/municipio?codigoMunicipio=' . $municipio->codigo_municipio);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($municipio) {

            $json->hasAll(['codigo_municipio', 'codigo_uf', 'nome', 'status']);

            $json->whereAllType([
                'codigo_uf' => 'integer',
                'codigo_municipio' => 'integer',
                'nome' => 'string',
                'status' => 'integer',
            ]);

            $json->whereAll([
                'codigo_uf' => $municipio->codigo_uf,
                'codigo_municipio' => $municipio->codigo_municipio,
                'nome' => $municipio->nome,
                'status' => $municipio->status,
            ]);
        });
    }

    public function testGetMunicipioEndpointWithFilterByStatus()
    {
        $municipio = Municipio::factory(1)->createOne();

        $response = $this->getJson('/api/municipio?status=' . $municipio->status);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($municipio) {

            $json->hasAll(['0.codigo_municipio', '0.codigo_uf', '0.nome', '0.status']);

            $json->whereAllType([
                '0.codigo_uf' => 'integer',
                '0.codigo_municipio' => 'integer',
                '0.nome' => 'string',
                '0.status' => 'integer',
            ]);

            $json->whereAll([
                '0.codigo_uf' => $municipio->codigo_uf,
                '0.codigo_municipio' => $municipio->codigo_municipio,
                '0.nome' => $municipio->nome,
                '0.status' => $municipio->status,
            ]);
        });
    }

    public function testGetMunicipioEndpointWithFilterByCodigoAndName()
    {
        $municipio = Municipio::factory(1)->createOne();

        $response = $this->getJson('/api/municipio?codigoMunicipio=' . $municipio->codigo_municipio . '&nome=' . $municipio->nome);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($municipio) {

            $json->hasAll(['codigo_municipio', 'codigo_uf', 'nome', 'status']);

            $json->whereAllType([
                'codigo_municipio' => 'integer',
                'codigo_uf' => 'integer',
                'nome' => 'string',
                'status' => 'integer',
            ]);

            $json->whereAll([
                'codigo_municipio' => $municipio->codigo_municipio,
                'codigo_uf' => $municipio->codigo_uf,
                'nome' => $municipio->nome,
                'status' => $municipio->status,
            ]);
        });
    }

    public function testPostMunicipioEndpoint()
    {
        $municipio = Municipio::factory(1)->makeOne()->toArray();

        $response = $this->postJson('/api/municipio', $municipio);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tb_municipio', [
            'codigo_uf' => $municipio['codigo_uf'],
            'nome' => $municipio['nome'],
            'status' => $municipio['status'],
        ]);

        $response->assertJson(['mensagem', 'Municipio cadastrada com sucesso.']);
    }

    public function testPutMunicipioEndpoint()
    {
        $municipio = Municipio::factory(1)->createOne();

        $payload = [
            'codigo_uf' => $municipio->codigo_uf,
            'nome' =>"Itapetinga",
            'status' => 1
        ];

        $response = $this->putJson('/api/municipio/'. $municipio->codigo_municipio, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tb_municipio',[
            'codigo_uf' => $payload['codigo_uf'],
            'nome' => $payload['nome'],
            'status' => $payload['status'],
        ]);
        $response->assertJson(function (AssertableJson $json) use ($payload){

            $json->hasAll(['0.codigo_uf', '0.codigo_municipio', '0.nome', '0.status']);

            $json->whereAll([
                '0.codigo_uf' => $payload['codigo_uf'],
                '0.nome' => $payload['nome'],
                '0.status' => $payload['status'],
            ]);
        });
    }

    public function testPutMunicipioShouldReturnErrorWhenDontFindMunicipio()
    {
        $municipio = Municipio::factory(1)->createOne();

        $payload = [
            'codigo_uf' => $municipio->codigo_uf,
            'nome' =>"Itapetinga",
            'status' => 1
        ];

        $response = $this->putJson('/api/municipio/999', $payload);

        $response->assertStatus(404);

        $response->assertJson(['mensagem' => 'Municipio não encontrado na base de dados.']);
    }

    public function testPostMunicipioShouldValidateWhenTryCreateAInvalidMunicipio()
    {
        $municipio = Municipio::factory(1)->createOne();

        $payload = [
            'codigo_uf' => $municipio->codigo_uf,
            'nome' => '',
            'status' => 1,
        ];
        $response = $this->postJson('/api/municipio',$payload);

        $response->assertStatus(422);

        $response->assertJson(function (AssertableJson $json) {

            $json->hasAll(['mensagem']);

        });
    }
}
