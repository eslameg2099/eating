<?php

namespace App\Models;

use App\Traits\HasMediaTrait;
use App\Http\Filters\Filterable;
use Spatie\MediaLibrary\HasMedia;
use App\Support\Traits\Selectable;
use App\Http\Filters\KitchenFilter;
use Malhal\Geographical\Geographical;
use App\Http\Resources\KitchenResource;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Resources\Json\JsonResource;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\Permission\Traits\HasRoles;

class Kitchen extends Model implements HasMedia
{
    use HasFactory ;
    use SoftDeletes ;
    use Filterable ;
    use Selectable;
    use InteractsWithMedia ;
    use HasUploader;
    use HasMediaTrait;
    use Favoriteable;
    use Geographical;
    use HasRoles;



    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = KitchenFilter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'city_id',
        'address',
        'description',
        'longitude',
        'latitude',
        'active',
        'active_special',
        'cookable_type',
        'rate',
        'reviewers',
        'verified_at',
        'map_addres',
    ];

    /**
     * @return \App\Http\Resources\KitchenResource
     */
    public function getResource()
    {
        return new KitchenResource($this);
    }

    /**
     * Relations.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active',1)->whereNotNull('verified_at');
    }

    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'kitchen_id');
    }

    public function votes() :object
    {
        return $this->hasMany(
            Vote::class,
            'kitchen_id'
        );
    }

    public function sponsor()
    {
        return $this->hasOne(KitchenSponsor::class, 'kitchen_id');
    }
    public function kitchenSponsorDurations()
    {
        return $this->hasMany(KitchenDuration::class, 'kitchen_id');
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->useFallbackPath(public_path('images/kitchen.png'))
            ->singleFile();
        $this
            ->addMediaCollection('attach')
            ->singleFile();
    }
    public function scopeVerified($query)
    {
        return $query->whereNull('verified_at');
    }
}
