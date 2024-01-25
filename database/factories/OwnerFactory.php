<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Owner>
 */
class OwnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $factory = [
            'cpf_cnpj' => $this->cpfGenerate(),
            'telephone_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'gender' => fake()->randomElement(['f', 'm'])
        ];

        $factory['name'] = fake()->name();

        return $factory;
    }

    private function cpfGenerate()
    {
        $nineDigit = '';
        for ($i = 0; $i < 9; $i++) {
            $nineDigit .= mt_rand(0, 9);
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += $nineDigit[$i] * (10 - $i);
        }
        $rest = $sum % 11;
        $oneDigit = ($rest < 2) ? 0 : 11 - $rest;

        $cpf = $nineDigit . $oneDigit;

        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $cpf[$i] * (11 - $i);
        }
        $rest = $sum % 11;
        $twoDigit = ($rest < 2) ? 0 : 11 - $rest;

        $cpf .= $twoDigit;

        return $cpf;
    }

}
