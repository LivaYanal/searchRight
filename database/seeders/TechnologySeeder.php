<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /** Veelgebruikte talen en frameworks bij stagebedrijven. */
    public function run(): void
    {
        $names = [
            'PHP', 'Laravel', 'JavaScript', 'TypeScript', 'React', 'Vue', 'HTML/CSS',
            'C#', '.NET', 'Unity', 'Java', 'Python', 'SQL', 'Docker', 'Go', 'Kotlin', 'Swift',
        ];

        foreach ($names as $name) {
            Technology::firstOrCreate(['name' => $name]);
        }
    }
}
