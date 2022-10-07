<?php

namespace App\Models;

use Parental\HasParent;
use App\Http\Filters\ChefFilter;
use App\Http\Resources\ChefResource;
use App\Http\Resources\CustomerResource;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chef extends User
{
    use HasFactory;
    use HasParent;
    use SoftDeletes;

    /**
     * The model filter name.
     *
     * @var string
     */
    protected $filter = ChefFilter::class;

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
     * @return ChefResource
     */
    public function getResource()
    {
        return new ChefResource($this->load('kitchen', 'city'));
    }

    /**
     * Get the dashboard profile link.
     *
     * @return string
     */
//    public function dashboardProfile(): string
//    {
//        return route('dashboard.chefs.show', $this);
//    }

    /**
     * Relations.
     */
    public function kitchen()
    {
        return $this->hasOne(Kitchen::class);
    }
    public function votes()
    {
        return $this->hasManyThrough(Vote::class,Kitchen::class,'user_id','kitchen_id');
    }


    public function meals()
    {
        return $this->hasManyThrough(
            Meal::class,
            Kitchen::class,
            'user_id',
            'kitchen_id',
            'id',
            'id'
        );
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'chef_id');
    }
    /**
     * Get the post's image.
     */
    public function cancel_order()
    {
        return $this->morphMany(CanceledOrder::class, 'cancelable');
    }


    public function special_orders()
    {
        return $this->hasManyThrough(
            SpecialOrder::class,
            Kitchen::class,
            'user_id',
            'kitchen_id',
            'id',
            'id'
        );
    }
}
