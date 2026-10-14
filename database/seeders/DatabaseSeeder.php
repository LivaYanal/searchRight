<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Company;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(TechnologySeeder::class);

        // Testaccount om mee in te loggen
        $user = User::factory()->create([
            'name' => 'Test Gebruiker',
            'email' => 'test@example.com',
        ]);

        // 8 voorbeeldbedrijven, elk met 0-4 talen en 1 sollicitatie
        Company::factory(8)
            ->for($user)
            ->has(Application::factory())
            ->create()
            ->each(function (Company $company) {
                $company->technologies()->attach(
                    Technology::inRandomOrder()->limit(rand(0, 4))->pluck('id')
                );
            });
    }
}
