<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\DeliveryCompany;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryCompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_delivery_companies()
    {
        $this->actingAsAdmin();

        DeliveryCompany::factory()->count(2)->create();

        $this->getJson(route('api.delivery_companies.index'))
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
    public function test_delivery_companies_select2_api()
    {
        DeliveryCompany::factory()->count(5)->create();

        $response = $this->getJson(route('api.delivery_companies.select'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'text'],
                ],
            ]);

        $this->assertEquals($response->json('data.0.id'), 1);

        $this->assertCount(5, $response->json('data'));

        $response = $this->getJson(route('api.delivery_companies.select', ['selected_id' => 4]))
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
    public function it_can_display_the_delivery_company_details()
    {
        $this->actingAsAdmin();

        $delivery_company = DeliveryCompany::factory(['name' => 'Foo'])->create();

        $response = $this->getJson(route('api.delivery_companies.show', $delivery_company))
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
