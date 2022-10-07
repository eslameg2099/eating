<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\SponsorDurationsFilter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;


class SponsorDurations extends Model implements TranslatableContract
{
    use HasFactory,SoftDeletes;
    use Translatable;
    use Filterable ;

    public $translatedAttributes = ['title', 'currency'];

    protected $translationForeignKey = 'sponsor_duration_id';
    protected $fillable =[
        'duration',
        'duration_type',
        'cost',
        'active'
    ];
    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = SponsorDurationsFilter::class;
}
