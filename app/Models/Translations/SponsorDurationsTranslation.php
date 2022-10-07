<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorDurationsTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'sponsor_duration_translations';
    protected $fillable = ['title', 'currency'];
}
