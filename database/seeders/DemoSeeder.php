<?php

namespace Database\Seeders;

use App\Enums\ApplicationStatus;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Demo-account voor bezoekers van de online versie.
 * Wordt bij elke start opnieuw klaargezet, zodat het bord er altijd netjes uitziet.
 * Alle bedrijven zijn verzonnen.
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => config('searchright.demo_email')],
            ['name' => 'Demo', 'password' => config('searchright.demo_password')],
        );

        // Oude demodata weg, verse demodata erin
        $user->companies()->delete();

        $companies = [
            ['Kodeklas', 'Amsterdam', 'Webdevelopment', 'Bouwt leerplatforms voor scholen. Zoekt een stagiair voor hun Laravel-team.', ['PHP', 'Laravel', 'Vue'], ApplicationStatus::ToSend, null, null],
            ['Pixelmolen', 'Zaandam', 'Gaming', 'Indie-studio die mobiele puzzelgames maakt.', ['C#', 'Unity'], ApplicationStatus::ToSend, null, null],
            ['Datadijk', 'Amsterdam', 'Data & AI', 'Maakt dashboards voor gemeenten en woningcorporaties.', ['Python', 'SQL'], ApplicationStatus::Sent, -6, 3],
            ['Grachtweb', 'Amsterdam', 'E-commerce', 'Webshops voor lokale winkels in de Jordaan.', [], ApplicationStatus::Sent, -3, 6],
            ['Stroopwafel Studio', 'Haarlem', 'Apps', 'Maakt apps voor festivals en evenementen.', ['Kotlin', 'Swift'], ApplicationStatus::Sent, -9, 1],
            ['Bitbaai', 'Amsterdam', 'Software op maat', 'Bouwt planningssoftware voor de thuiszorg.', ['C#', '.NET', 'SQL'], ApplicationStatus::Interview, -12, 2],
            ['Tegeltech', 'Diemen', 'Webdevelopment', 'Bureau voor websites van sportclubs.', ['JavaScript', 'React'], ApplicationStatus::Rejected, -20, null],
        ];

        foreach ($companies as [$name, $city, $focus, $description, $tech, $status, $sentDaysAgo, $followUpInDays]) {
            $company = $user->companies()->create([
                'name' => $name,
                'city' => $city,
                'focus' => $focus,
                'description' => $description,
                'website' => 'https://example.com',
            ]);

            $company->technologies()->sync(
                collect($tech)->map(fn ($t) => Technology::firstOrCreate(['name' => $t])->id)
            );

            $company->applications()->create([
                'status' => $status,
                'sent_at' => $sentDaysAgo !== null ? today()->addDays($sentDaysAgo) : null,
                'follow_up_at' => $followUpInDays !== null ? today()->addDays($followUpInDays) : null,
                'notes' => $status === ApplicationStatus::Interview ? "Gesprek met de lead developer.\nLaptop meenemen voor een kleine opdracht." : null,
            ]);
        }
    }
}
