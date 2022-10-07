<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_packages()
    {
        $this->actingAsAdmin();

        Package::factory()->count(2)->create();

        $this->getJson(route('api.packages.index'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ]);
    }

    /** @test */
    public function test_packages_select2_api()
    {
        Package::factory()->count(5)->create();

        $response = $this->getJson(route('api.packages.select'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'text'],
                ],
            ]);

        $this->assertEquals($response->json('data.0.id'), 1);

        $this->assertCount(5, $response->json('data'));

        $response = $this->getJson(route('api.packages.select', ['selected_id' => 4]))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'text'],
                ],
            ]);

        $this->assertEquals($response->json('data.0.id'), 4);

        $this->assertCount(5, $response->json('data'));
    }

    /** @test */
    public function it_can_display_the_package_details()
    {
        $this->actingAsAdmin();

        $package = Package::factory(['name' => 'Foo'])->create();

        $response = $this->getJson(route('api.packages.show', $package))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ],
            ]);

        $this->assertEquals($response->json('data.name'), 'Foo');
    }
}
