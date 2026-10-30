<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'mrp' => 'decimal:2',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'gst_percent' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_new' => 'boolean',
        'stock' => 'integer',
        'application_area' => 'array',
         'weight' => 'decimal:2'
    ];

 


public function rooms()
{
    return $this->belongsToMany(
        Room::class,
        'product_room',
        'product_id',
        'room_id'
    );
}

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_product_id');
    }

    /**
     * Many-to-many relationship with rooms.
     */
    // public function rooms()
    // {
    //     return $this->belongsToMany(Room::class, 'product_room', 'product_id', 'room_id');
    // }

    public function getFeaturedImageAttribute()
    {
        $firstImage = $this->images()->first();
        return $firstImage ? $firstImage->image_path : 'images/placeholder-product.jpg';
    }
}
