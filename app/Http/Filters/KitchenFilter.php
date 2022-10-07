<?php

namespace App\Http\Filters;
use Illuminate\Support\Facades\DB;

class KitchenFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'city_id',
        'nearest',
        'rate',
        'selected_id',
        'cookable_type',
        'order_by_reviews',
        'meal',
        'category_id',
        'cost',
        'chef'
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function cost($value)
    {
        if ($value) {
            if($value == 1 ) {
                return $this->builder->with(['meals' => function($query) {
                    $query->orderBy('meals.cost', 'asc')->orderBy('meals.cost_after_discount','asc');
                }]);
            }
            if($value == 2){
                return $this->builder->with(['meals' => function($query) {
                    $query->orderBy('meals.cost', 'desc')->orderBy('meals.cost_after_discount','desc');
                }]);
            }
        }

        return $this->builder;
    }
    protected function categoryId($value)
    {
        if ($value) {
            return $this->builder->whereHas('meals', function ($query) use($value) {
                $query->where('meals.category_id','like', "%$value%");
            });
        }

        return $this->builder;
    }
    protected function meal($value)
    {
        if ($value) {
            return $this->builder->whereHas('meals', function ($query) use($value) {
                $query->where('meals.name','like', "%$value%");
            });
        }

        return $this->builder;
    }
    protected function chef($value)
    {
        if ($value) {
            return $this->builder->whereHas('user', function ($query) use($value) {
                $query->where('users.name','like', "%$value%");
            });
        }

        return $this->builder;
    }
    protected function name($value)
    {
        if ($value) {
            return $this->builder->where('name', 'like', "%$value%");
        }

        return $this->builder;
    }

    protected function cookableType($value)
    {
        if ($value) {
            return $this->builder->where('cookable_type', 'LIKE', "%".$value."%");
        }

        return $this->builder;
    }

    protected function cityId($value)
    {
        if ($value) {
            return $this->builder->where('city_id', $value);
        }

        return $this->builder;
    }

    protected function nearest($value)
    {
        if ($value) {
            
            return $this->builder->distance($this->request->latitude, $this->request->longitude)->oldest('distance');
            
         //   $lat = $this->request->latitude;
         //   $long = $this->request->longitude; 
          //  $this->builder->selectRaw('SELECT  *,111.045*DEGREES(ACOS(COS(RADIANS(':lat'))*COS(RADIANS(`latitude`))*COS(RADIANS(`longitude`) - RADIANS(':long'))+SIN(RADIANS(':lat'))*SIN(RADIANS(`latitude`)))) AS distance_in_km FROM kitchens ORDER BY distance_in_km asc LIMIT 0,5');

    //   $parties=DB::select(DB::raw("SELECT  *,111.045*DEGREES(ACOS(COS(RADIANS(':lat'))*COS(RADIANS(`latitude`))*COS(RADIANS(`longitude`) - RADIANS(':long'))+SIN(RADIANS(':lat'))*SIN(RADIANS(`latitude`)))) AS distance_in_km FROM kitchens ORDER BY distance_in_km asc LIMIT 0,5"), array(
       //     'lat' => $lat,
      //      'long' => $long
      //  ));
      //  return 123;
       }

        return $this->builder;
    }

    protected function rate($value)
    {
        if ($value) {
            return $this->builder->orderByDesc('rate');
        }

        return $this->builder;
    }
}
