<?php


namespace App\Http\Filters;


use App\Models\City;

class CityFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'id'
    ];
    /**
     * Filter the query by a given status.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($value)
    {
        if ($value)
            return $this->builder->whereTranslationLike('name','%'.$value.'%');
        return $this->builder;
    }
    protected function id($value)
    {
        if ($value) return $this->builder->where('status', $value);
        return $this->builder;
    }

}
