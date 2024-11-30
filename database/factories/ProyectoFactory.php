<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

//use App\Models\Proyecto; // importacion del modelo 

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proyecto>
 */
class ProyectoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    //protected $model = Proyecto::class;
    public function definition(): array
    {
        return [
            //
            'nombre' => fake()->sentence(),
            'descripcion'  => fake()->paragraph(),
        ];
    }
}
