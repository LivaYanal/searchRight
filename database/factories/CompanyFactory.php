<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    public function definition(): array
    {
        $focus = fake()->randomElement([
            'Webdevelopment', 'Gaming', 'Apps', 'Software op maat', 'E-commerce', 'Data & AI',
        ]);

        return [
            'user_id' => User::factory(),
            'name' => fake()->company(),
            'city' => fake()->randomElement(['Amsterdam', 'Amstelveen', 'Zaandam', 'Haarlem', 'Diemen']),
            'website' => fake()->url(),
            'stagemarkt_url' => null,
            'focus' => $focus,
            'description' => "Wij zijn een team dat zich richt op {$focus}.",
            'contact_name' => fake()->name(),
            'contact_email' => fake()->companyEmail(),
            'contact_phone' => fake()->phoneNumber(),
        ];
    }
}
