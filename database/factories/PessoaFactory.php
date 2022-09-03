<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pessoa>
 */
class PessoaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $senha = strval($this->faker->randomNumber(9));
        return [
            'nome' => $this->faker->firstName(),
            'sobrenome' => $this->faker->lastName(),
            'idade' => $this->faker->numberBetween(1, 40),
            'login' => $this->faker->email(),
            'senha' => $senha,
            'status' => $this->faker->numberBetween(1,2),
        ];
    }
}
