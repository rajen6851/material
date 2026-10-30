<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $fillable = [
        'phone',
        'email',
        'address',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'youtube_url',
    ];
}
