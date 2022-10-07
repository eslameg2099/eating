<?php

namespace App\Models;

use ChristianKuri\LaravelFavorite\Models\Favorite;
use ChristianKuri\LaravelFavorite\Traits\Favoriteability;
use Illuminate\Notifications\DatabaseNotification;
use Parental\HasChildren;
use App\Traits\WalletTrait;
use App\Http\Filters\Filterable;
use App\Http\Filters\UserFilter;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use App\Support\Traits\Selectable;
use App\Models\Helpers\UserHelpers;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Resources\CustomerResource;
use App\Models\Presenters\UserPresenter;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Facades\Pusher;

class User extends Authenticatable implements HasMedia
{
    use HasFactory;
    use Notifiable;
    use UserHelpers;
    use HasChildren;
    use InteractsWithMedia;
    use HasApiTokens;
    use HasChildren;
    use PresentableTrait;
    use Filterable;
    use Selectable;
    use HasUploader;
    use Impersonate;
    use HasRoles;
    use WalletTrait;
    use Favoriteability;



    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    /**
     * Return a collection with the User favorited Model.
     * The Model needs to have the Favoriteable trait
     *
     * @param  $class *** Accepts for example: Post::class or 'App\Post' ****
     * @return Collection
     */
    public function favorite($class)
    {
        return $this->favorites()->where('favoriteable_type', $class)->with('favoriteable',function ($query){
            $query->filter();
        })->get()
            ->mapWithKeys(function ($item) {
                if (isset($item['favoriteable'])) {
                    return [$item['favoriteable']->id=>$item['favoriteable']];
                }

                return [];
            });
    }
    /**
     * The code of admin type.
     *
     * @var string
     */
    const ADMIN_TYPE = 'admin';
    /**
     * The code of admin type.
     *
     * @var string
     */
    const SUPERVISOR_TYPE = 'chef';

    /**
     * The code of chef type.
     *
     * @var string
     */
    const CHEF_TYPE = 'chef';

    /**
     * The code of customer type.
     *
     * @var string
     */
    const CUSTOMER_TYPE = 'customer';
    /**
     * The code of delegate type.
     *
     * @var string
     */
    const DELEGATE_TYPE = 'delegate';

    /**
     * The guard name of the user permissions.
     *
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'city_id',
        'identity_number',
        'phone_verified_at',
        'password',
        'country_id',
        'remember_token',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['media'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $childTypes = [
        self::ADMIN_TYPE => Admin::class,
        self::SUPERVISOR_TYPE => Chef::class,
        self::CHEF_TYPE => Chef::class,
        self::CUSTOMER_TYPE => Customer::class,
        self::DELEGATE_TYPE => Delegate::class,
    ];
    public function isCustomer()
    {
        return $this->type == self::CUSTOMER_TYPE;
    }


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The presenter class name.
     *
     * @var string
     */
    protected $presenter = UserPresenter::class;

    /**
     * The model filter name.
     *
     * @var string
     */
    protected $filter = UserFilter::class;

    /**
     * Get the dashboard profile link.
     *
     * @return string
     */
    public function dashboardProfile(): string
    {
        return '#';
    }

    /**
     * Get the number of models to return per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }

    /**
     * Get the resource for customer type.
     *
     * @return \App\Http\Resources\CustomerResource
     */
    public function getResource()
    {
        return new CustomerResource($this->load('city'));
    }

    /**
     * Get the access token currently associated with the user. Create a new.
     *
     * @param string|null $device
     * @return string
     */
    public function createTokenForDevice($device = null)
    {
        $device = $device ?: 'Unknown Device';

        $this->tokens()->where('name', $device)->delete();

        return $this->createToken($device)->plainTextToken;
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
            ->useFallbackUrl('https://www.gravatar.com/avatar/'.md5($this->email).'?d=mm')
            ->singleFile()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(70)
                    ->format('png');

                $this->addMediaConversion('small')
                    ->width(120)
                    ->format('png');

                $this->addMediaConversion('medium')
                    ->width(160)
                    ->format('png');

                $this->addMediaConversion('large')
                    ->width(320)
                    ->format('png');
            });
    }

    /**
     * Determine whither the user can impersonate another user.
     *
     * @return bool
     */
    public function canImpersonate()
    {
        return $this->isAdmin();
    }

    /**
     * Determine whither the user can be impersonated by the admin.
     *
     * @return bool
     */
//    public function canBeImpersonated()
//    {
//        return $this->isChef();
//    }

    /**
     * User Relations.
     *
     * @return object
     */
    /**
     * A user can have many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Get the post's image.
     */
    public function vote()
    {
        return $this->hasMany(Vote::class);
    }
    public function is_voted($model)
    {
        if (get_class($model) == SpecialOrder::class) return $this->vote()->where('special_order_id',$model->id)->exists();
        return $this->vote()->where('meal_id',$model->id)->exists();
    }
    public function vote_rate($model)
    {
        if (get_class($model) == SpecialOrder::class) $this->is_voted($model) ? $this->vote()->where('special_order_id',$model->id)->first()->rate : null;
        return $this->is_voted($model) ? $this->vote()->where('meal_id',$model->id)->first()->rate : null;
    }



    /**
     * Get the post's image.
     */
    public function wallet()
    {
        return $this->morphMany(Wallet::class, 'walletable');
    }
    public function credit()
    {
        return $this->hasOne(Credit::class, 'user_id');
    }
    public function withdraw()
    {
        return $this->hasOne(Withdrawal::class, 'user_id');
    }

    /**
     * A user can have many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    /**
     * A user can have many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms()
    {
        return $this->hasMany(Room::class, 'receiver_id');
    }

    /**
     * A user can have many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    /**
     * Get the entity's notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }
    public function withdrawal()
    {
        return $this->hasMany(Withdrawal::class)->whereNull('confirmed_at')->latest();
    }
    public function cancel_order()
    {
        return $this->morphMany(CanceledOrder::class, 'cancelable');
    }

     public function isSubscribedTo(string $channelName): bool
    {
        $channelName = Str::startsWith($channelName, 'presence-') ? $channelName : "presence-$channelName";

        $response = Pusher::get("/channels/$channelName/users");

        if ($response && data_get($response, 'status') == 200) {
            return collect(data_get($response, 'result.users'))->where('id', $this->getKey())->isNotEmpty();
        }

        return false;
    }
}
