<?php


namespace App\Models\Helpers;


use App\Models\Package;
use DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Laraeast\LaravelSettings\Facades\Settings;

class priceHelper
{

    /**
     *
     * Fixed Delivery Cost
     *
     * @return double
     */
    public static function fixedDeliveryCost($distance): float
    {
        
        $package = Package::where('from_kg','<=',$distance)->where('to_kg','>=',$distance)
        ->first();
        if($package != null)
        {
            $cost = $package->cost;
        }
        else
       {
            $cost   =   Settings::get('delivery_cost') * (float) $distance ;
            if($cost >= 10000)
            {
                $cost = 10000;
            }
       }
       
       // return (float) $package ?  $package->cost : Settings::get('delivery_cost') ;
        return (float) $cost ;
    }
    /**
     *
     * Admin Commission on Order
     *
     * @return double
     */
    public static function adminCommission(): float
    {
        return (float) Settings::get('admin_commission');

    }
    public static function taxesAndServiceOnSpecialOrders() :float
    {
        return (float)((self::taxRatio()*self::adminCommission())/100) + ((self::additionalAddedTax()*self::adminCommission())/100);
    }
    /**
     *
     * Tax Ratio
     *
     * @return double
     */
    public static function taxRatio(): float
    {
        return (float) Settings::get('tax_ratio');
    }
    /**
     *
     * Tax Ratio
     *
     * @return double
     */
    public static function additionalAddedTax(): float
    {
        return (float) Settings::get('additional_added_tax');
    }

    /**
     *
     * Calculate Order Over all Cost
     *
     * @return double
     */
    public static function order_all_cost($distance, $fixed_deliveryCost, $admin_commission , $tax_ratio,  $additional_added_tax): float
    {
        $value = ($distance * $fixed_deliveryCost) + $admin_commission + (($tax_ratio/100)*$admin_commission) + (($additional_added_tax/100) * $admin_commission);
        return (float) $value;

    }
    /**
     *
     * Calculate Order Over all Cost
     *
     * @return double
     */
    public static function total($distance = 0 , $discount = 0): float
    {
        $fixed_deliveryCost = self::fixedDeliveryCost($distance);
        $admin_commission = self::adminCommission();
        $tax_ratio = self::taxRatio();
        $additional_added_tax = self::additionalAddedTax();
        $admin_commission = ($discount) ? ($admin_commission - (($discount/100) * $admin_commission)) : $admin_commission;
      //  $value = ($distance * $fixed_deliveryCost) + $admin_commission + (($tax_ratio/100)*$admin_commission) + (($additional_added_tax/100) * $admin_commission);
      $value = ($fixed_deliveryCost);
        return (float) $value;

    }
    public static function deliveryDistance($kitchen_long,$kitchen_lat,$user_long,$user_lat)
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
            'origins' => $kitchen_lat .','. $kitchen_long,
            'destinations' => 'side_of_road:'.$user_lat.','.$user_long,
            'key' => config('services.google_matrix'),
        ]);
        $directions = collect($response->json());
        if (isset($directions['error_message'])) throw ValidationException::withMessages(["message" => "cannot  decide user location."]);
        $direction_element = $directions['rows'][0]['elements'][0];
        if($direction_element["status"] == "OK"){
            $distance = explode(' ', $direction_element["distance"]["text"]);
            ($distance[1] == 'km') ? $distance = $distance[0] : $distance = ($distance[0] / 1000);
        }
//        $cost = priceHelper::order_all_cost($distance, priceHelper::fixedDeliveryCost(), priceHelper::adminCommission() ,priceHelper::taxRatio(), priceHelper::additionalAddedTax());
        return $distance;
    }

}
