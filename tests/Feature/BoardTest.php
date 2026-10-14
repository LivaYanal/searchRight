<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoardTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_board_shows_companies_in_their_status_column(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->for($user)->create(['name' => 'Bitbaai']);
        Application::factory()->for($company)->create(['status' => ApplicationStatus::Interview]);

        $this->actingAs($user)->get('/')
            ->assertOk()
            ->assertSee('Mijn stagezoektocht')
            ->assertSee('Bitbaai')
            ->assertSee('data-column="interview"', false);
    }

    public function test_the_board_shows_the_countdown(): void
    {
        config(['searchright.internship_start' => today()->addDays(10)->toDateString()]);

        $this->actingAs(User::factory()->create())->get('/')
            ->assertOk()
            ->assertSee('Stage begint over')
            ->assertSee('10');
    }

    public function test_dragging_a_card_updates_the_status_as_json(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->for($user)->create();
        Application::factory()->for($company)->create(['status' => ApplicationStatus::ToSend, 'sent_at' => null]);

        $this->actingAs($user)
            ->patchJson("/companies/{$company->id}/status", ['status' => 'sent'])
            ->assertOk()
            ->assertJson(['status' => 'sent', 'label' => 'Verstuurd'])
            ->assertJsonPath('stats', fn ($html) => str_contains($html, 'Sollicitaties verstuurd') && str_contains($html, '100% van je lijst'));

        $application = $company->latestApplication()->first();
        $this->assertSame(ApplicationStatus::Sent, $application->status);
        $this->assertTrue($application->sent_at->isToday(), 'Verstuurdatum wordt automatisch vandaag');
    }

    public function test_stats_count_companies_per_status(): void
    {
        $user = User::factory()->create();
        foreach (['to_send', 'sent', 'interview', 'interview'] as $status) {
            Application::factory()->for(Company::factory()->for($user))->create(['status' => $status]);
        }

        $stats = \App\Services\BoardStats::for($user);

        $this->assertSame(4, $stats['companies']);
        $this->assertSame(3, $stats['sent']);
        $this->assertSame(75, $stats['sentPercentage']);
        $this->assertSame(2, $stats['interviews']);
    }

    public function test_a_company_without_application_gets_one_when_the_status_changes(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->for($user)->create();

        $this->actingAs($user)
            ->patch("/companies/{$company->id}/status", ['status' => 'interview'])
            ->assertRedirect();

        $this->assertSame(ApplicationStatus::Interview, $company->fresh()->currentStatus());
    }

    public function test_an_invalid_status_is_rejected(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->for($user)->create();

        $this->actingAs($user)
            ->patchJson("/companies/{$company->id}/status", ['status' => 'verzonnen'])
            ->assertUnprocessable();
    }

    public function test_you_cannot_change_the_status_of_someone_elses_company(): void
    {
        $company = Company::factory()->create();

        $this->actingAs(User::factory()->create())
            ->patchJson("/companies/{$company->id}/status", ['status' => 'accepted'])
            ->assertForbidden();
    }

    public function test_dates_and_notes_can_be_saved(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->for($user)->create();

        $this->actingAs($user)
            ->patch("/companies/{$company->id}/application", [
                'sent_at' => '2026-10-03',
                'follow_up_at' => '2026-10-16',
                'notes' => 'Laptop meenemen',
            ])
            ->assertRedirect();

        $application = $company->latestApplication()->first();
        $this->assertSame('2026-10-16', $application->follow_up_at->toDateString());
        $this->assertSame('Laptop meenemen', $application->notes);
    }
}
