<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspiration extends Model
{
    protected $guarded = [];

    protected $casts = [
        'materials' => 'array',
    ];
}
