<?php

namespace Database\Factories;

use App\Models\DeliveryCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryCompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeliveryCompany::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'create' => 'http://driverapi.wenetlb.net/api/homezCreateOrder',
            'cancel' => 'http://driverapi.wenetlb.net/api/HomezOrderCancelation',
            'get' => 'http://driverapi.wenetlb.net/api/getHomezOrderStatus',
        ];
    }
}
