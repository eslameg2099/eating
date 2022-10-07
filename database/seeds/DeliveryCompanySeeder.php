<?php

namespace Database\Seeders;

use App\Models\DeliveryCompany;
use Illuminate\Database\Seeder;

class DeliveryCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliveryCompany::factory()->count(1)->create();
    }
}
