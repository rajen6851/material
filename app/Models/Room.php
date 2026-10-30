<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'tagline'];

    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }
    
    public function products()
{
    return $this->belongsToMany(
        Product::class,
        'product_room',
        'room_id',
        'product_id'
    );
}
}
