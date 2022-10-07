<?php

namespace App\Models;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use App\Traits\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KitchenSponsor extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia,SoftDeletes;
    use HasUploader;
    use HasMediaTrait;
    /**
     * The code of online payment.
     *
     * @var int
     */
    const ONLINE_PAYMENT = 0;

    /**
     * The code of cash payment.
     *
     * @var int
     */
    const WALLET_PAYMENT = 1;

    /**
     * The code of online payment.
     *
     * @var int
     */
    const PENDING_STATUS = 0;

    /**
     * The code of cash payment.
     *
     * @var int
     */
    const ACCEPTED_STATUS = 1;
    /**
     * The code of cash payment.
     *
     * @var int
     */
    const REJECTED_STATUS = 2;

    protected $table = 'kitchen_sponsor';
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['media'];
    protected $fillable =[
        'kitchen_id',
        'kitchen_duration_id',
        'sponsor_duration_id' ,
        'start_date',
        'end_date',
        'paid',
        'accepted',
        'checkout_id',
        'payment_type'
    ];
    protected $dates = ['start_date','end_date'];
    public function kitchenDuration()
    {
        return $this->belongsToMany(KitchenDuration::class,'kitchen_duration_id');
    }
    public function sponsor_duration(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SponsorDurations::class,'sponsor_duration_id');
    }

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
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
            ->singleFile();
    }
}
