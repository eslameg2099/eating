<?php

namespace App\Models;

use App\Traits\HasMediaTrait;
use App\Http\Filters\Filterable;
use App\Http\Filters\MealFilter;
use Spatie\MediaLibrary\HasMedia;
use App\Support\Traits\Selectable;
use App\Http\Resources\MealResource;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Resources\Json\JsonResource;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;

class Meal extends Model implements HasMedia
{
    use HasFactory ;
    use HasMediaTrait;
    use SoftDeletes ;
    use Filterable ;
    use Selectable;
    use InteractsWithMedia ;
    use HasUploader;
    use Favoriteable;
    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = MealFilter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'category_id',
        'kitchen_id',
        'name',
        'description',
        'cost',
        'cost_after_discount',
    ];

    /**
     * @return \App\Http\Resources\MealResource
     */
    public function getResource() :object
    {
        return new MealResource($this);
    }

    /**
     * Relations.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }
    public function orderItem()
    {
        return $this->hasMany(OrderItem::class,'meal_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('Meal')
            ->useFallbackPath(public_path('images/meal.png'));
//            ->singleFile();
    }
    /**
     * Get the product's price.
     *
     * @return float
     */
    public function getPrice()
    {
        if (! is_null($this->cost_after_discount)) {
            return $this->cost_after_discount;
        }

        return $this->cost;
    }
}
