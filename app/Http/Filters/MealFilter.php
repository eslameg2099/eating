<?php

namespace App\Http\Filters;

use DB;
use Illuminate\Http\Request;

class MealFilter extends BaseFilters
{


    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'order_by',
        'category_id',
        'kitchen_id',
        'kitchen_type',
        'name',
        'cost',
        'selected_id',
        'offer',
        'rate',
        'except_meal_id'
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function orderBy($value)
    {
        $order_by = ['asc','desc'];
        if(count($value) == 2){
            if (in_array($value[1],$order_by)){
                if($value[0] != '') return $this->builder->orderBy($value[0], $value[1]);
            }
        }

        return $this->builder;
    }

    protected function selectedId($value)
    {
        if ($value) {
            return $this->builder->where($this->table.'.id', 'like', "%$value%");
        }

        return $this->builder;
    }
    protected function rateDesc($value)
    {
        if ($value) {
            return $this->builder->withCount(['votes as average_rate' => function($query) {
                $query->select(DB::raw('coalesce(avg(rate),0)'));
            }])->orderByDesc('average_rate');
        }

        return $this->builder;
    }
    protected function rate($value)
    {
        if ($value) {
            return $this->builder->withCount(['votes as average_rate' => function($query) {
                $query->select(DB::raw('coalesce(avg(rate),0)'));
            }])->orderBy('average_rate','asc');
        }

        return $this->builder;
    }


    protected function categoryId($value)
    {
        if ($value) {
            return $this->builder->where($this->table.'.category_id', '=', "$value");
        }

        return $this->builder;
    }

    protected function kitchenId($value)
    {
        if ($value) {
            return $this->builder->where($this->table.'.kitchen_id', '=', "$value");
        }

        return $this->builder;
    }

    protected function name($value)
    {
        if ($value) {
            return $this->builder->where($this->table.'.name', 'like', "%$value%");
        }

        return $this->builder;
    }

    protected function cost($value)
    {
        if ($value) {
            if($value == 1){
                return $this->builder->orderBy($this->table.'.cost','asc')->orderBy($this->table.'.cost_after_discount','asc');
            }
            if($value == 2){
                return $this->builder->orderBy($this->table.'.cost','desc')->orderBy($this->table.'.cost_after_discount','desc');
            }
        }
        return $this->builder;
    }

    protected function offer($value)
    {
        if ($value) {
            return $this->builder->whereNotNull($this->table.'.cost_after_discount');
        }
        return $this->builder;
    }
    protected function kitchenType($value)
    {
        if ($value) {
            return $this->builder->whereHas('kitchen', function ($query) use ($value){
              $query->where('kitchens.cookable_type','like', "%$value%");
            });
        }
        return $this->builder;
    }
    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function exceptMealId($value)
    {
        if($value){
            return $this->builder->where('id', '!=', $value);
        }

        return $this->builder;
    }
}
