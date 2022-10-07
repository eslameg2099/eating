<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Parental\HasParent;
use App\Http\Filters\CustomerFilter;
use App\Http\Resources\CustomerResource;
use App\Models\Relations\CustomerRelations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use ChristianKuri\LaravelFavorite\Traits\Favoriteability;


class Customer extends User
{
    use HasFactory;
    use HasParent;
    use CustomerRelations;
    use SoftDeletes;
    use Favoriteability;
    use Notifiable;

    /**
     * The model filter name.
     *
     * @var string
     */
    protected $filter = CustomerFilter::class;

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass()
    {
        return User::class;
    }

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'user_id';
    }

    /**
     * @return \App\Http\Resources\CustomerResource
     */
    public function getResource()
    {
        return new CustomerResource($this->load('city'));
    }

    /**
     * Get the dashboard profile link.
     *
     * @return string
     */
    public function dashboardProfile(): string
    {
        return route('dashboard.customers.show', $this);
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    public function special_orders()
    {
        return $this->hasMany(SpecialOrder::class,'user_id');
    }
    public function complaints()
    {
        return $this->hasMany(Complaint::class,'user_id');
    }
    /**
     * Get the post's image.
     */
    public function cancel_order()
    {
        return $this->morphMany(CanceledOrder::class, 'cancelable');
    }

}
