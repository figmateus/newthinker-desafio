<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Uf;

class UfControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testGetUfEndpointWithoutFilter()
    {
        $ufs = Uf::factory(3)->create();
//        dd($ufs);
        $response = $this->getJson('/api/uf');

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($ufs){

            $json->hasAll(['0.sigla', '0.nome', '0.status']);

            $json->whereAllType([
               '0.codigo_uf' => 'integer',
               '0.sigla'=>'string',
               '0.nome'=>'string',
               '0.status'=> 'integer',
           ]);

            $json->whereAll([
                '0.codigo_uf' => $ufs[0]->codigo_uf,
                '0.sigla'=> $ufs[0]->sigla,
                '0.nome'=> $ufs[0]->nome,
                '0.status' => $ufs[0]->status,
            ]);
        });
    }

    public function testGetUfEndpointShouldReturnEmptyJsonWhenDontFoundUf()
    {
        $response = $this->getJson('/api/uf?nome=IT');
        $response->assertStatus(404);
        $response->assertJson([]);
    }

    public function testGetUfEndpointWithFilterByName()
    {
        $uf = Uf::factory(1)->createOne();

        $response = $this->getJson('/api/uf?nome=' . $uf->nome);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($uf){

            $json->hasAll(['codigo_uf','sigla', 'nome', 'status']);

            $json->whereAllType([
                'codigo_uf' => 'integer',
                'sigla'=>'string',
                'nome'=>'string',
                'status'=>'integer',
            ]);

            $json->whereAll([
                'codigo_uf' => $uf->codigo_uf,
                'sigla'=> $uf->sigla,
                'nome'=> $uf->nome,
                'status' => $uf->status,
            ]);
        });
    }

    public function testGetUfEndpointWithFilterBySigla()
    {
        $uf = Uf::factory(1)->createOne();

        $response = $this->getJson('/api/uf?sigla=' . $uf->sigla);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($uf){

            $json->hasAll(['codigo_uf','sigla', 'nome', 'status']);

            $json->whereAllType([
                'codigo_uf' => 'integer',
                'sigla'=>'string',
                'nome'=>'string',
                'status'=>'integer',
            ]);

            $json->whereAll([
                'codigo_uf' => $uf->codigo_uf,
                'sigla'=> $uf->sigla,
                'nome'=> $uf->nome,
                'status' => $uf->status,
            ]);
        });
    }

    public function testGetUfEndpointWithFilterByCodigoAndName()
    {
        $uf = Uf::factory(1)->createOne();

        $response = $this->getJson('/api/uf?codigoUF='.$uf->codigo_uf.'&nome='.$uf->nome);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($uf){

            $json->hasAll(['codigo_uf','sigla', 'nome', 'status']);

            $json->whereAllType([
                'codigo_uf' => 'integer',
                'sigla'=>'string',
                'nome'=>'string',
                'status'=>'integer',
            ]);

            $json->whereAll([
                'codigo_uf' => $uf->codigo_uf,
                'sigla'=> $uf->sigla,
                'nome'=> $uf->nome,
                'status' => $uf->status,
            ]);
        });
    }

    public function testPostUfEndpoint()
    {
        $uf = Uf::factory(1)->makeOne()->toArray();

        $response = $this->postJson('/api/uf', $uf);

        $response->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) use ($uf){

            $json->hasAll(['codigo_uf','sigla', 'nome', 'status']);

            $json->whereAll([
                'sigla'=> $uf['sigla'],
                'nome'=> $uf['nome'],
                'status' => $uf['status'],
            ]);
        });
    }

    public function testPutUfEndpoint()
    {
        $uf = Uf::factory(1)->createOne();

        $payload = [
                'sigla' => "BA",
                'nome' =>"BAHIA UPDATE",
                'status' => 1
        ];

        $response = $this->putJson('/api/uf/'. $uf->codigo_uf, $payload);

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($payload){

            $json->hasAll(['codigo_uf', 'sigla', 'nome', 'status']);

            $json->whereAll([
                'sigla' => $payload['sigla'],
                'nome' => $payload['nome'],
                'status' => $payload['status'],
            ]);
        });
    }

    public function testPutUfShouldReturnEmptyJsonWhenDontUpdateUf()
    {
        $uf = Uf::factory(1)->createOne();

        $payload = [
            'sigla' => "BA",
            'nome' =>"BAHIA UPDATE",
            'status' => 1
        ];

        $response = $this->putJson('/api/uf/4', $payload);

        $response->assertStatus(400);

        $response->assertJson(['mensagem' => 'Não foi possível alterar, pois já existe um registro de UF com a mesma sigla cadastrada.']);
    }

    public function testPostUfShouldValidateWhenTryCreateAInvalidBook()
    {

        $uf = [
            'codigo_uf' => 22,
            'sigla' => 'A',
            'nome' => 'AMAZONAS',
            'status' => 1,
        ];
        $response = $this->postJson('/api/uf',$uf);

        $response->assertStatus(422);

        $response->assertJson(function (AssertableJson $json) {

            $json->hasAll(['mensagem']);

        });
    }
}
