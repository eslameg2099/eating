<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_coupons()
    {
        $this->actingAsAdmin();

        Coupon::factory()->count(2)->create();

        $this->getJson(route('api.coupons.index'))
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
    public function test_coupons_select2_api()
    {
        Coupon::factory()->count(5)->create();

        $response = $this->getJson(route('api.coupons.select'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'text'],
                ],
            ]);

        $this->assertEquals($response->json('data.0.id'), 1);

        $this->assertCount(5, $response->json('data'));

        $response = $this->getJson(route('api.coupons.select', ['selected_id' => 4]))
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
    public function it_can_display_the_coupon_details()
    {
        $this->actingAsAdmin();

        $coupon = Coupon::factory(['name' => 'Foo'])->create();

        $response = $this->getJson(route('api.coupons.show', $coupon))
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
