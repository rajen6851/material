<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionHeading extends Model
{
    protected $fillable = [
        'section_key',
        'heading',
        'subheading',
    ];
}