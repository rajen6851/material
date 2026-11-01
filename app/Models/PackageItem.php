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

    /**
     * Resolve linked Product from product_id or cat_no (SKU)
     */
    public function getLinkedProductAttribute()
    {
        if ($this->relationLoaded('product') && $this->product) {
            return $this->product;
        }
        if ($this->product_id) {
            return $this->product;
        }
        if (!empty($this->cat_no)) {
            $cat = trim($this->cat_no);
            $p = Product::where('sku', $cat)->orWhere('sku', 'like', $cat)->first();
            if ($p) {
                return $p;
            }
        }
        if (!empty($this->name)) {
            $name = trim($this->name);
            $p = Product::where('name', $name)->orWhere('name', 'like', "%{$name}%")->first();
            if ($p) {
                return $p;
            }
        }
        return null;
    }

    /**
     * Get product detail page URL if linked to catalog product
     */
    public function getDetailUrlAttribute()
    {
        $prod = $this->linked_product;
        if ($prod && !empty($prod->slug)) {
            return route('products.show', $prod->slug);
        }
        return null;
    }

    public function getDisplayImageAttribute()
    {
        if ($this->image) {
            return asset($this->image);
        }
        $prod = $this->linked_product;
        if ($prod && $prod->featured_image) {
            return asset($prod->featured_image);
        }
        return null;
    }

    /**
     * Get selling price (from item override or product table)
     */
    public function getEffectivePriceAttribute()
    {
        if (!empty($this->price) && $this->price > 0) {
            return (float) $this->price;
        }
        $prod = $this->linked_product;
        if ($prod && $prod->price > 0) {
            return (float) $prod->price;
        }
        return null;
    }

    /**
     * Get original MRP directly from products table
     */
    public function getEffectiveMrpAttribute()
    {
        $prod = $this->linked_product;
        if ($prod) {
            if ($prod->mrp > 0) {
                return (float) $prod->mrp;
            }
            if ($prod->discount > 0 && $this->effective_price > 0) {
                return (float) round($this->effective_price / (1 - ($prod->discount / 100)));
            }
        }
        return null;
    }

    /**
     * Get discount percentage directly from products table
     */
    public function getDiscountPercentAttribute()
    {
        $prod = $this->linked_product;
        if ($prod && $prod->discount > 0) {
            return (int) round($prod->discount);
        }
        $mrp = $this->effective_mrp;
        $price = $this->effective_price;
        if ($mrp && $price && $mrp > $price) {
            return (int) round((($mrp - $price) / $mrp) * 100);
        }
        return null;
    }
}
