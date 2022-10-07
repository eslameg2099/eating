<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_a_list_of_packages()
    {
        $this->actingAsAdmin();

        Package::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.packages.index'))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_the_package_details()
    {
        $this->actingAsAdmin();

        $package = Package::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.packages.show', $package))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_packages_create_form()
    {
        $this->actingAsAdmin();

        $this->get(route('dashboard.packages.create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_a_new_package()
    {
        $this->actingAsAdmin();

        $packagesCount = Package::count();

        $response = $this->post(
            route('dashboard.packages.store'),
            Package::factory()->raw([
                'name' => 'Foo'
            ])
        );

        $response->assertRedirect();

        $package = Package::all()->last();

        $this->assertEquals(Package::count(), $packagesCount + 1);

        $this->assertEquals($package->name, 'Foo');
    }

    /** @test */
    public function it_can_display_the_packages_edit_form()
    {
        $this->actingAsAdmin();

        $package = Package::factory()->create();

        $this->get(route('dashboard.packages.edit', $package))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_update_the_package()
    {
        $this->actingAsAdmin();

        $package = Package::factory()->create();

        $response = $this->put(
            route('dashboard.packages.update', $package),
            Package::factory()->raw([
                'name' => 'Foo'
            ])
        );

        $package->refresh();

        $response->assertRedirect();

        $this->assertEquals($package->name, 'Foo');
    }

    /** @test */
    public function it_can_delete_the_package()
    {
        $this->actingAsAdmin();

        $package = Package::factory()->create();

        $packagesCount = Package::count();

        $response = $this->delete(route('dashboard.packages.destroy', $package));

        $response->assertRedirect();

        $this->assertEquals(Package::count(), $packagesCount - 1);
    }

    /** @test */
    public function it_can_display_trashed_packages()
    {
        if (! $this->useSoftDeletes($model = Package::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        Package::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.packages.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_package_details()
    {
        if (! $this->useSoftDeletes($model = Package::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $package = Package::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.packages.trashed.show', $package));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_restore_deleted_package()
    {
        if (! $this->useSoftDeletes($model = Package::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $package = Package::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.packages.restore', $package));

        $response->assertRedirect();

        $this->assertNull($package->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_force_delete_package()
    {
        if (! $this->useSoftDeletes($model = Package::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $package = Package::factory()->create(['deleted_at' => now()]);

        $packageCount = Package::withTrashed()->count();

        $this->actingAsAdmin();

        $response = $this->delete(route('dashboard.packages.forceDelete', $package));

        $response->assertRedirect();

        $this->assertEquals(Package::withoutTrashed()->count(), $packageCount - 1);
    }

    /** @test */
    public function it_can_filter_packages_by_name()
    {
        $this->actingAsAdmin();

        Package::factory()->create([
            'name' => 'Foo',
        ]);

        Package::factory()->create([
            'name' => 'Bar',
        ]);

        $this->get(route('dashboard.packages.index', [
            'name' => 'Fo',
        ]))
            ->assertSuccessful()
            ->assertSee(trans('packages.filter'))
            ->assertSee('Foo')
            ->assertDontSee('Bar');
    }
}
