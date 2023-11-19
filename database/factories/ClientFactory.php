<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contact_name' => fake()->name(),
            'company_name' => fake()->company(),
            'company_address' => fake()->address(),
            'contact_phone_number' => fake()->phoneNumber(),
            'contact_email' => fake()->unique()->safeEmail(),
            'company_city' =>  fake()->city(),
            'contact_zip' =>   fake()->postcode(),
            'company_vat' =>   fake()->randomDigit(),
        ];
    }
}
