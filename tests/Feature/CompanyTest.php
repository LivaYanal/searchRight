<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Models\Company;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_see_companies(): void
    {
        $this->get('/companies')->assertRedirect(route('login'));
    }

    public function test_a_user_only_sees_their_own_companies(): void
    {
        $user = User::factory()->create();
        Company::factory()->for($user)->create(['name' => 'Mijn Bedrijf']);
        Company::factory()->create(['name' => 'Iemand Anders BV']);

        $this->actingAs($user)->get('/companies')
            ->assertOk()
            ->assertSee('Mijn Bedrijf')
            ->assertDontSee('Iemand Anders BV');
    }

    public function test_a_user_can_add_a_company_with_technologies(): void
    {
        $user = User::factory()->create();
        $php = Technology::create(['name' => 'PHP']);

        $this->actingAs($user)->post('/companies', [
            'name' => 'Pixel Games',
            'focus' => 'Gaming',
            'description' => 'Wij maken mobiele games.',
            'website' => 'www.pixelgames.nl',
            'technologies' => [$php->id],
            'new_technologies' => 'Unity, C#',
        ])->assertRedirect(route('board'));

        $company = $user->companies()->first();

        $this->assertSame('Pixel Games', $company->name);
        $this->assertSame('https://www.pixelgames.nl', $company->website);
        $this->assertSame('C#, PHP, Unity', $company->technology_list);
        $this->assertSame('PG', $company->initials);

        // Een nieuw bedrijf begint in de kolom "Te versturen"
        $this->assertSame(ApplicationStatus::ToSend, $company->fresh()->currentStatus());
    }

    public function test_a_custom_focus_overrides_the_chosen_option(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/companies', [
            'name' => 'Veilig BV',
            'focus' => 'Webdevelopment',
            'focus_other' => 'Cybersecurity',
        ]);

        $this->assertSame('Cybersecurity', $user->companies()->first()->focus);
    }

    public function test_the_detail_page_shows_the_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->for($user)->create(['name' => 'Bitbaai']);

        $this->actingAs($user)->get("/companies/{$company->id}")
            ->assertOk()
            ->assertSee('Bitbaai')
            ->assertSee('Status van je sollicitatie');
    }

    public function test_technology_list_shows_a_dash_when_empty(): void
    {
        $company = Company::factory()->create();

        $this->assertSame('-', $company->technology_list);
    }

    public function test_name_is_required(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/companies', ['name' => ''])
            ->assertSessionHasErrors('name');
    }

    public function test_a_user_can_update_their_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->for($user)->create();

        $this->actingAs($user)
            ->put("/companies/{$company->id}", ['name' => 'Nieuwe Naam'])
            ->assertRedirect(route('companies.show', $company));

        $this->assertSame('Nieuwe Naam', $company->fresh()->name);
    }

    public function test_a_user_cannot_edit_or_delete_someone_elses_company(): void
    {
        $company = Company::factory()->create();
        $intruder = User::factory()->create();

        $this->actingAs($intruder)->get("/companies/{$company->id}")->assertForbidden();
        $this->actingAs($intruder)->get("/companies/{$company->id}/edit")->assertForbidden();
        $this->actingAs($intruder)->put("/companies/{$company->id}", ['name' => 'Gehackt'])->assertForbidden();
        $this->actingAs($intruder)->delete("/companies/{$company->id}")->assertForbidden();

        $this->assertModelExists($company);
    }

    public function test_a_user_can_delete_their_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->for($user)->create();

        $this->actingAs($user)->delete("/companies/{$company->id}")
            ->assertRedirect(route('companies.index'));

        $this->assertModelMissing($company);
    }
}
