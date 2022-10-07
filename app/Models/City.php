<?php

namespace App\Models;

use App\Http\Filters\CityFilter;
use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class City extends Model implements TranslatableContract
{
    use HasFactory , Translatable, SoftDeletes , Filterable;

    public $translatedAttributes = ['name'];

    protected $fillable = [
      'name',
    ];
    protected $filter = CityFilter::class;
}
