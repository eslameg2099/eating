<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\DeliveryCompany;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryCompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_a_list_of_delivery_companies()
    {
        $this->actingAsAdmin();

        DeliveryCompany::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.delivery_companies.index'))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_the_delivery_company_details()
    {
        $this->actingAsAdmin();

        $delivery_company = DeliveryCompany::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.delivery_companies.show', $delivery_company))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_delivery_companies_create_form()
    {
        $this->actingAsAdmin();

        $this->get(route('dashboard.delivery_companies.create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_a_new_delivery_company()
    {
        $this->actingAsAdmin();

        $delivery_companiesCount = DeliveryCompany::count();

        $response = $this->post(
            route('dashboard.delivery_companies.store'),
            DeliveryCompany::factory()->raw([
                'name' => 'Foo'
            ])
        );

        $response->assertRedirect();

        $delivery_company = DeliveryCompany::all()->last();

        $this->assertEquals(DeliveryCompany::count(), $delivery_companiesCount + 1);

        $this->assertEquals($delivery_company->name, 'Foo');
    }

    /** @test */
    public function it_can_display_the_delivery_companies_edit_form()
    {
        $this->actingAsAdmin();

        $delivery_company = DeliveryCompany::factory()->create();

        $this->get(route('dashboard.delivery_companies.edit', $delivery_company))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_update_the_delivery_company()
    {
        $this->actingAsAdmin();

        $delivery_company = DeliveryCompany::factory()->create();

        $response = $this->put(
            route('dashboard.delivery_companies.update', $delivery_company),
            DeliveryCompany::factory()->raw([
                'name' => 'Foo'
            ])
        );

        $delivery_company->refresh();

        $response->assertRedirect();

        $this->assertEquals($delivery_company->name, 'Foo');
    }

    /** @test */
    public function it_can_delete_the_delivery_company()
    {
        $this->actingAsAdmin();

        $delivery_company = DeliveryCompany::factory()->create();

        $delivery_companiesCount = DeliveryCompany::count();

        $response = $this->delete(route('dashboard.delivery_companies.destroy', $delivery_company));

        $response->assertRedirect();

        $this->assertEquals(DeliveryCompany::count(), $delivery_companiesCount - 1);
    }

    /** @test */
    public function it_can_display_trashed_delivery_companies()
    {
        if (! $this->useSoftDeletes($model = DeliveryCompany::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        DeliveryCompany::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.delivery_companies.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_delivery_company_details()
    {
        if (! $this->useSoftDeletes($model = DeliveryCompany::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $delivery_company = DeliveryCompany::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.delivery_companies.trashed.show', $delivery_company));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_restore_deleted_delivery_company()
    {
        if (! $this->useSoftDeletes($model = DeliveryCompany::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $delivery_company = DeliveryCompany::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.delivery_companies.restore', $delivery_company));

        $response->assertRedirect();

        $this->assertNull($delivery_company->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_force_delete_delivery_company()
    {
        if (! $this->useSoftDeletes($model = DeliveryCompany::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $delivery_company = DeliveryCompany::factory()->create(['deleted_at' => now()]);

        $delivery_companyCount = DeliveryCompany::withTrashed()->count();

        $this->actingAsAdmin();

        $response = $this->delete(route('dashboard.delivery_companies.forceDelete', $delivery_company));

        $response->assertRedirect();

        $this->assertEquals(DeliveryCompany::withoutTrashed()->count(), $delivery_companyCount - 1);
    }

    /** @test */
    public function it_can_filter_delivery_companies_by_name()
    {
        $this->actingAsAdmin();

        DeliveryCompany::factory()->create([
            'name' => 'Foo',
        ]);

        DeliveryCompany::factory()->create([
            'name' => 'Bar',
        ]);

        $this->get(route('dashboard.delivery_companies.index', [
            'name' => 'Fo',
        ]))
            ->assertSuccessful()
            ->assertSee(trans('delivery_companies.filter'))
            ->assertSee('Foo')
            ->assertDontSee('Bar');
    }
}
