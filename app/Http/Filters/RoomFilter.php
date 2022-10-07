<?php

namespace App\Http\Filters;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class RoomFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'today',
        'receiver',
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function today($value)
    {
        if ($value) {
            return $this->builder->whereDate('updated_at', Carbon::today());
        }
        return $this->builder;
    }

    protected function receiver($value)
    {
        if ($value) {
            $user = User::where('name', 'LIKE', '%'.$value.'%')->first();
        }
        if (! isset($user['id'])) {
            return $this->builder->where('receiver_id', $user['id'] ?? 0) ;
        }
    }
}
