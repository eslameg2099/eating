<?php

namespace App\Http\Filters;

use App\Models\Order;

class OrderFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'status',
        'tab',
        'today',
        'selected_id',
        'id',
        'kitchen'
    ];

    /**
     * Filter the query by a given status.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function kitchen($value)
    {
        if ($value)
        {
            return $this->builder->whereHas('kitchen',function ($query) use ($value) {
                $query->where('name','like','%'.$value.'%');
            });
        }
    }
    protected function id($value)
    {
        if ($value)
        {
            return $this->builder->where('id', $value);
        }
    }
    protected function status($value)
    {
        return $this->builder->where('status', $value);
    }

    /**
     * Filter the query by a given status.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function tab($value)
    {
        switch ($value) {
            case 'totallyNew':
                $status = [Order::REQUEST_STATUS,Order::PENDING_STATUS,Order::COOKING_STATUS,Order::COOKED_STATUS,Order::RECEIVED_STATUS];
                return $this->builder->whereIn('status', $status);
            case 'totallyEnd':
            $status = [Order::DELIVERED_STATUS,Order::CUSTOMER_CANCEL,Order::CHEF_CANCEL];
            return $this->builder->whereIn('status', $status);

            case 'new':
                $status = [Order::REQUEST_STATUS];
                return $this->builder->whereIn('status', $status);
            case 'pending':
                $status = [Order::PENDING_STATUS];
                return $this->builder->whereIn('status', $status);

            case 'working':
                $status = [Order::COOKING_STATUS];
                return $this->builder->whereIn('status', $status);

            case 'cooked':
                $status = [Order::COOKED_STATUS];
                return $this->builder->whereIn('status', $status);
                break;
            case 'done':
                $status = [Order::RECEIVED_STATUS,Order::DELIVERED_STATUS];
                return $this->builder->whereIn('status', $status);
                break;
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

    /**
     * Filter the query to include only orders created today.
     *
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function today($value)
    {
        if ($value) {
            $this->builder->whereDate('created_at', today());
        }

        return $this->builder;
    }
}
