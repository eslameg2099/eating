<?php


namespace App\Http\Filters;


use App\Models\SpecialOrder;

class SpecialOrderFilter extends BaseFilters
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
        if ($value) return $this->builder->where('status', $value);
        return $this->builder;
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
                $status = [SpecialOrder::REQUEST_STATUS,SpecialOrder::ACCEPT_STATUS,SpecialOrder::APPROVED_STATUS];
                return $this->builder->whereIn('status', $status);
            case 'totallyEnd':
                $status = [SpecialOrder::FINISHED_STATUS,SpecialOrder::USER_CANCEL,SpecialOrder::CHEF_CANCEL,SpecialOrder::ADMIN_CANCEL];
                return $this->builder->whereIn('status', $status);
            case 'new':
                $status = [SpecialOrder::REQUEST_STATUS];

                return $this->builder->whereIn('status', $status);
            case 'pending':
                $status = [SpecialOrder::ACCEPT_STATUS];

                return $this->builder->whereIn('status', $status);

            case 'working':
                $status = [SpecialOrder::APPROVED_STATUS];

                return $this->builder->whereIn('status', $status);

            case 'done':
                $status = [SpecialOrder::FINISHED_STATUS];

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
