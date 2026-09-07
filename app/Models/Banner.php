<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['image', 'title', 'subtitle', 'link', 'type', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
