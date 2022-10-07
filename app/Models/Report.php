<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\ReportFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;
    use Filterable;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'customer_id',
        'chef_id',
        'kitchen_id',
        'order_id',
        'message',
        'read_at',
    ];
    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = ReportFilter::class;


    /**
     * Relations.
     */

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chef()
    {
        return $this->belongsTo(Chef::class, 'chef_id');
    }
    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class, 'kitchen_id');
    }
    /**
     * Determine whither the message was read.
     *
     * @return bool
     */
    public function read()
    {
        return ! ! $this->read_at;
    }

    /**
     * Mark the message as read.
     *
     * @return $this
     */
    public function markAsRead()
    {
        if (! $this->read()) {
            $this->forceFill(['read_at' => now()])->save();
        }

        return $this;
    }

    /**
     * Mark the message as unread.
     *
     * @return $this
     */
    public function markAsUnread()
    {
        if ($this->read()) {
            $this->forceFill(['read_at' => null])->save();
        }

        return $this;
    }

    /**
     * Scope the query to include only unread messages.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}
