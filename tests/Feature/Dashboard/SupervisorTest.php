<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Chef;

class ChefTest extends TestCase
{
    /** @test */
    public function it_can_display_list_of_chefs()
    {
        $this->actingAsAdmin();

        Chef::factory()->create(['name' => 'Ahmed']);

        $response = $this->get(route('dashboard.chefs.index'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_chef_details()
    {
        $this->actingAsAdmin();

        $chef = Chef::factory()->create(['name' => 'Ahmed']);

        $response = $this->get(route('dashboard.chefs.show', $chef));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_chef_create_form()
    {
        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.chefs.create'));

        $response->assertSuccessful();

        $response->assertSee(trans('chefs.actions.create'));
    }

    /** @test */
    public function it_can_create_chefs()
    {
        $this->actingAsAdmin();

        $chefsCount = Chef::count();

        $response = $this->postJson(
            route('dashboard.chefs.store'),
            [
                'name' => 'Chef',
                'email' => 'chef@demo.com',
                'phone' => '123456789',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]
        );

        $response->assertRedirect();

        $this->assertEquals(Chef::count(), $chefsCount + 1);
    }

    /** @test */
    public function it_can_display_chef_edit_form()
    {
        $this->actingAsAdmin();

        $chef = Chef::factory()->create();

        $response = $this->get(route('dashboard.chefs.edit', $chef));

        $response->assertSuccessful();

        $response->assertSee(trans('chefs.actions.edit'));
    }

    /** @test */
    public function it_can_update_chefs()
    {
        $this->actingAsAdmin();

        $chef = Chef::factory()->create();

        $response = $this->put(
            route('dashboard.chefs.update', $chef),
            [
                'name' => 'Chef',
                'email' => 'chef@demo.com',
                'phone' => '123456789',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]
        );

        $response->assertRedirect();

        $chef->refresh();

        $this->assertEquals($chef->name, 'Chef');
    }

    /** @test */
    public function it_can_delete_chef()
    {
        $this->actingAsAdmin();

        $chef = Chef::factory()->create();

        $chefsCount = Chef::count();

        $response = $this->delete(route('dashboard.chefs.destroy', $chef));
        $response->assertRedirect();

        $this->assertEquals(Chef::count(), $chefsCount - 1);
    }

    /** @test */
    public function it_can_display_trashed_chefs()
    {
        if (! $this->useSoftDeletes($model = Chef::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        Chef::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.chefs.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_chef_details()
    {
        if (! $this->useSoftDeletes($model = Chef::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $chef = Chef::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.chefs.trashed.show', $chef));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_restore_deleted_chef()
    {
        if (! $this->useSoftDeletes($model = Chef::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $chef = Chef::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.chefs.restore', $chef));

        $response->assertRedirect();

        $this->assertNull($chef->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_force_delete_chef()
    {
        if (! $this->useSoftDeletes($model = Chef::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $chef = Chef::factory()->create(['deleted_at' => now()]);

        $chefCount = Chef::withTrashed()->count();

        $this->actingAsAdmin();

        $response = $this->delete(route('dashboard.chefs.forceDelete', $chef));

        $response->assertRedirect();

        $this->assertEquals(Chef::withoutTrashed()->count(), $chefCount - 1);
    }

    /** @test */
    public function it_can_filter_chefs_by_name()
    {
        $this->actingAsAdmin();

        Chef::factory()->create(['name' => 'Ahmed']);

        Chef::factory()->create(['name' => 'Mohamed']);

        $this->get(route('dashboard.chefs.index', [
            'name' => 'ahmed',
        ]))
            ->assertSuccessful()
            ->assertSee('Ahmed')
            ->assertDontSee('Mohamed');
    }

    /** @test */
    public function it_can_filter_chefs_by_email()
    {
        $this->actingAsAdmin();

        Chef::factory()->create([
            'name' => 'FooBar1',
            'email' => 'user1@demo.com',
        ]);

        Chef::factory()->create([
            'name' => 'FooBar2',
            'email' => 'user2@demo.com',
        ]);

        $this->get(route('dashboard.chefs.index', [
            'email' => 'user1@',
        ]))
            ->assertSuccessful()
            ->assertSee('FooBar1')
            ->assertDontSee('FooBar2');
    }

    /** @test */
    public function it_can_filter_chefs_by_phone()
    {
        $this->actingAsAdmin();

        Chef::factory()->create([
            'name' => 'FooBar1',
            'phone' => '123',
        ]);

        Chef::factory()->create([
            'name' => 'FooBar2',
            'email' => '456',
        ]);

        $this->get(route('dashboard.chefs.index', [
            'phone' => '123',
        ]))
            ->assertSuccessful()
            ->assertSee('FooBar1')
            ->assertDontSee('FooBar2');
    }
}
