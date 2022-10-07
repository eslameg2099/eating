<?php

namespace App\Models;

use App\Traits\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Category extends Model implements TranslatableContract, HasMedia
{
    use HasFactory , Translatable , SoftDeletes;
    use HasUploader;
    use HasMediaTrait;
    use InteractsWithMedia ;


    public $translatedAttributes = ['title'];
    protected $fillable = [
        'active_at'
    ];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['media'];
    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->useFallbackUrl('https://www.gravatar.com/avatar')
            ->singleFile();
    }

}
