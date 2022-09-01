<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Municipio;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bairro>
 */
class BairroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $municipio = Municipio::factory(1)->createOne();
        return [
            "codigo_municipio" => $municipio->codigo_municipio,
            "nome" => $this->faker->streetName(),
            "status" => $this->faker->numberBetween(1,2)
        ];
    }
}
