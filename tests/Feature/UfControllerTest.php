<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Uf;

class UfControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_uf_endpoint_without_filter()
    {
        $ufs = Uf::factory(1)->create();

        $response = $this->getJson('/api/uf');

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($ufs){

            $json->hasAll(['0.sigla', '0.nome', '0.status']);

            $json->whereAllType([
               '0.codigo_uf' => 'integer',
               '0.sigla'=>'string',
               '0.nome'=>'string',
               '0.status'=>'boolean',
           ]);
            $uf = $ufs->first();
            $json->whereAll([
                '0.codigo_uf' => $uf->codigo_uf,
                '0.sigla'=> $uf->sigla,
                '0.nome'=> $uf->nome,
                '0.status' => $uf->status,
            ]);
        });
    }

    public function test_get_uf_endpoint_with_filter()
    {
        $uf = Uf::factory(1)->createOne();

        $response = $this->getJson('/api/uf/' . $uf->codigo_uf);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($uf){

            $json->hasAll(['codigo_uf','sigla', 'nome', 'status']);

            $json->whereAllType([
                'codigo_uf' => 'integer',
                'sigla'=>'string',
                'nome'=>'string',
                'status'=>'boolean',
            ]);

            $json->whereAll([
                'codigo_uf' => $uf->codigo_uf,
                'sigla'=> $uf->sigla,
                'nome'=> $uf->nome,
                'status' => $uf->status,
            ]);
        });
    }

    public function test_post_uf_endpoint()
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
}
