<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Chef;
use App\Models\City;
use App\Models\Meal;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Kitchen;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use App\Models\SponsorDurations;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->call('media-library:clean');

        $this->call(RolesAndPermissionsSeeder::class);

        $admin = Admin::factory()->createOne([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'phone' => '111111111',
        ]);

        /** @var Chef $chef */
        $chef = Chef::factory()->createOne([
            'name' => 'Chef',
            'email' => 'chef@demo.com',
            'phone' => '222222222',
        ]);

        $customer = Customer::factory()->createOne([
            'name' => 'Customer',
            'email' => 'customer@demo.com',
            'phone' => '333333333',
        ]);
        $address = Address::create([
            'addressable_id' => $customer->id,
            'addressable_type' => 'App\Models\User',
            'type' => 'Home',
            'description' => 'اسأل علي حمادة عضمة',
            'longitude' => '31.2240349',
            'latitude' => '29.8148008',
        ]);

        $city = City::factory()->createOne([
            'name:ar' => 'المدينة المنورة',
            'name:en' => 'Al-Madina Al-Menoura',
        ]);

        $categories = Category::factory()->createOne([
            'title:ar' => 'فطار',
            'title:en' => 'BreakFast',
        ]);
        $kitchen = Kitchen::create([
            'user_id' => Chef::first()->id,
            'name' => 'kitchen 1 test',
            'city_id' => City::first()->id,
            'address' => 'مكان قريب',
            'description' => 'اكل بيتي',
            'longitude' => '31.2413747',
            'latitude' => '29.9722956',
            'active' => 1,
            'active_special' => 1,
            'cookable_type' => 'Kitchen',
        ]);
        $meal = Meal::create([
            'category_id' => Category::first()->id,
            'kitchen_id' => Kitchen::first()->id,
            'name' => 'فرخة مشوية',
            'description' => 'تقدم مع الرز والبطاطس والطحينة' ,
            'cost' => 200,
            'cost_after_discount' => null,
        ]);
        $order = Order::create([
            'user_id' => $customer->id ,
            'chef_id' => $chef->id,
            'kitchen_id' => $kitchen->id,
            'delivery_id' => null,
            'address_id' => $address->id,
            'total_cost' => 200,
            'total_discount' => null,
            'purchased' => 0,
            'payment_method' => 2,
            'delegate_id' => null,
            'status' => 0,
            'notes' => null,
            'cooked_at' => null,
            'received_at' => null,
            'delivered_at'=> null,
        ]);
        $sponsor_duration = SponsorDurations::create([
            'title' => 'ترقية شهرية',
            'locale' => 'ar',
            'duration' => '1',
            'duration_type' => 'month',
            'cost' => '100',
            'currency' => 'sar',
        ]);


        $this->call([
            DummyDataSeeder::class,
        ]);

        $this->command->table(['ID', 'Name', 'Email', 'Phone', 'Password', 'Type', 'Type Code'], [
            [$admin->id, $admin->name, $admin->email, $admin->phone, 'password', 'Admin', $admin->type],
            [
                $chef->id,
                $chef->name,
                $chef->email,
                $chef->phone,
                'password',
                'Chef',
                $chef->type,
            ],
            [
                $customer->id,
                $customer->name,
                $customer->email,
                $customer->phone,
                'password',
                'Customer',
                $customer->type,
            ],
        ]);
    }
}
