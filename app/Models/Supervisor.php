<?php

namespace App\Models;

use App\Http\Resources\ChefResource;
use Parental\HasParent;
use App\Http\Filters\ChefFilter;
use App\Http\Resources\CustomerResource;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Resources\Json\JsonResource;
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
     * @return \App\Http\Resources\ChefResource
     */
    public function getResource()
    {
        return new ChefResource($this);
    }

    /**
     * Get the dashboard profile link.
     *
     * @return string
     */
    public function dashboardProfile(): string
    {
        return route('dashboard.chefs.show', $this);
    }
}
