<?php

namespace App\Models;

use Parental\HasParent;
use App\Traits\HasMediaTrait;
use App\Http\Filters\DelegateFilter;
use App\Http\Resources\DelegateResource;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delegate extends User
{
    use HasFactory;
    use HasParent;
    use SoftDeletes;
    use HasMediaTrait;

    /**
     * The model filter name.
     *
     * @var string
     */
    protected $filter = DelegateFilter::class;

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
     * @return DelegateResource
     */
    public function getResource()
    {
        return new DelegateResource($this);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'delivery_id');
    }

    public function vehicle() :object
    {
        return $this->hasOne(Vehicle::class, 'user_id');
    }

    public function assign_order() :object
    {
        return $this->hasOne(AssignOrder::class, 'delegate_id');
    }

    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatars')
            ->useFallbackUrl('https://www.gravatar.com/avatar/' . md5($this->email) . '?d=mm')
            ->singleFile();
        $this->addMediaCollection('identity_front_image')->singleFile();
        $this->addMediaCollection('identity_back_image')->singleFile();
    }
}
