<?php


namespace App\Http\Filters;


use Carbon\Carbon;

class ReportFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
      'order_id',
      'customer',
      'kitchen',
      'read_at'
    ];
    /**
     * Filter the query by a given name.
     *
     * @param boolean $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function orderId($value)
    {
       if($value) $this->builder->where('order_id',$value);
        return $this->builder;
    }
    /**
     * Filter the query by a given name.
     *
     * @param boolean $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function customer($value): \Illuminate\Database\Eloquent\Builder
    {
        if($value)return $this->builder->whereHas('customer',function ($query) use($value){
            $query->where('name','LIKE','%'.$value.'%');
        });
        return $this->builder;
    }
    /**
     * Filter the query by a given name.
     *
     * @param boolean $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function kitchen($value)
    {
        if($value)return $this->builder->whereHas('kitchen',function ($query) use($value){
            $query->where('name','LIKE','%'.$value.'%');
        });
        return $this->builder;
    }
    /**
     * Filter the query by a given name.
     *
     * @param boolean $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function read($value)
    {
        if(!is_null($value)){
            if(! $value) return $this->builder->whereNull('read_at');
            if($value) return $this->builder->whereNotNull('read_at');
        }
        return $this->builder;
    }
    /**
     * Filter the query by a given name.
     *
     * @param boolean $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function today($value)
    {
        if($value)return $this->builder->whereDate('created_at', Carbon::today());
        return $this->builder;
    }
    protected function readAt($value)
    {
        if ($value == 'read') {
            return $this->builder->whereNotNull('read_at');
        }
        if ($value == 'unread') {
            return $this->builder->whereNull('read_at');
        }

        return $this->builder;
    }

}
