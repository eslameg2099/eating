<?php


namespace App\Http\Filters;


use Carbon\Carbon;

class WalletFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
      'type',
      'withdrew',
      'deposit',
      'confirmed',
      'today'
    ];
    /**
     * Filter the query by a given name.
     *
     * @param boolean $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function type($value)
    {
        switch ($value){
            case 1:
                $this->withdrew(true);
                break;
            case 2:
                $this->deposit(true);
                break;
            default:
                break;
        }
        if($value)return $this->builder->where('title','withdrew');
        return $this->builder;
    }
    /**
     * Filter the query by a given name.
     *
     * @param boolean $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function withdrew($value)
    {
        if($value)return $this->builder->where('title','withdrew');
        return $this->builder;
    }
    /**
     * Filter the query by a given name.
     *
     * @param boolean $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function deposit($value)
    {
        if($value)return $this->builder->where('title','deposit');
        return $this->builder;
    }
    /**
     * Filter the query by a given name.
     *
     * @param boolean $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function confirmed($value)
    {
        if($value)return $this->builder->where('title','withdrew')->where('confirmed',1);
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


}
