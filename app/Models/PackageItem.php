<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'area',
        'product_id',
        'cat_no',
        'name',
        'description',
        'image',
        'price',
        'quantity',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'sort_order' => 'integer',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getDisplayImageAttribute()
    {
        if ($this->image) {
            return asset($this->image);
        }
        if ($this->product && $this->product->featured_image) {
            return asset($this->product->featured_image);
        }
        return null;
    }
}

