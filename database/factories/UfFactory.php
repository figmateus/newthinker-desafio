<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Uf>
 */
class UfFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
//            'codigo_uf'=>$this->faker->randomNumber(2),
            'sigla' => $this->faker->stateAbbr(),
            'nome'=>$this->faker->state(),
            'status'=>$this->faker->numberBetween(1,2),
        ];
    }
}
