<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CityTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public $timestamps = false;
}
