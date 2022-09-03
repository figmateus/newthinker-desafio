<?php

namespace Database\Factories;

use App\Models\Bairro;
use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Endereco>
 */
class EnderecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'codigo_pessoa' => Pessoa::factory(),
            'codigo_bairro' => Bairro::factory(),
            'nome_rua' => $this->faker->streetName(),
            'numero' => $this->faker->randomNumber(3),
            'complemento' => $this->faker->text(20),
            'cep' => $this->faker->postcode(),
        ];
    }
}
