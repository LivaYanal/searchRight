<?php

namespace Database\Factories;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Application>
 */
class ApplicationFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(ApplicationStatus::cases());
        $sentAt = $status === ApplicationStatus::ToSend ? null : fake()->dateTimeBetween('-4 weeks', 'now');

        return [
            'company_id' => Company::factory(),
            'status' => $status,
            'sent_at' => $sentAt,
            'follow_up_at' => $sentAt ? fake()->dateTimeBetween('now', '+2 weeks') : null,
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
