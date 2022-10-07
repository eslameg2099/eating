<?php

namespace App\Http\Filters;

class DeliveryFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'delivery_company',
        'selected_id',
        'from_date',
        'to_date',
    ];

    /**
     * Filter the query by a given delivery_company.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function deliveryCompany($value)
    {
        if ($value) {
            return $this->builder->whereHas('delivery_company',function ($query) use($value){
                $query->where('name', 'like', "%$value%");
            });
        }

        return $this->builder;
    }
    protected function fromDate($value)
    {
        if ($value) {
            return $this->builder->whereDate('created_at','>=',$value);
        }

        return $this->builder;
    }
    protected function toDate($value)
    {
        if ($value) {
            return $this->builder->whereDate('created_at','<=',$value);
        }

        return $this->builder;
    }

    /**
     * Sorting results by the given id.
     *
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function selectedId($value)
    {
        if ($value) {
            $this->builder->sortingByIds($value);
        }

        return $this->builder;
    }
}
