<?php

namespace Database\Factories;

use App\Models\Uf;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Municipio>
 */
class MunicipioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $uf = Uf::factory(1)->createOne();

        return [
            'codigo_uf' => $uf->codigo_uf,
            'nome' => $this->faker->city(),
            'status' => $this->faker->numberBetween(1,2),
        ];
    }
}
