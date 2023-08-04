<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->text(30),
            'status' => $this->faker->randomElement(['done', 'not done']),
            'question_id' => $this->faker->numberBetween(1, 5),
            'session_id' => null,
            'user_id' => null,
        ];
    }

}