<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'brand_id',
        'tagline',
        'description',
        'image',
        'price',
        'mrp',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'mrp' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($package) {
            if (empty($package->slug)) {
                $package->slug = Str::slug($package->name);
                // Ensure unique slug
                $originalSlug = $package->slug;
                $count = 1;
                while (static::where('slug', $package->slug)->exists()) {
                    $package->slug = "{$originalSlug}-" . $count++;
                }
            }
        });
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function items()
    {
        return $this->hasMany(PackageItem::class)->with('product')->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Group items by area (e.g. Basin Area, WC Area, Shower Area)
     */
    public function itemsGroupedByArea()
    {
        return $this->items->groupBy('area');
    }

    /**
     * Get computed total MRP of all items in package
     */
    public function getCalculatedMrpAttribute()
    {
        return (float) $this->items->sum(function ($item) {
            $mrp = $item->effective_mrp ?: $item->effective_price;
            return ($mrp ?? 0) * ($item->quantity ?? 1);
        });
    }

    /**
     * Get computed total selling price of all items in package
     */
    public function getCalculatedTotalAttribute()
    {
        return (float) $this->items->sum(function ($item) {
            return ($item->effective_price ?? ($item->price ?? 0)) * ($item->quantity ?? 1);
        });
    }

    /**
     * Get effective package MRP (from package->mrp, or sum of item MRPs/prices)
     */
    public function getEffectiveMrpAttribute()
    {
        $calcMrp = (float) $this->calculated_mrp;
        $calcTotal = (float) $this->calculated_total;
        $savedMrp = !empty($this->attributes['mrp']) ? (float) $this->attributes['mrp'] : 0;

        // If saved MRP in DB matches the selling price total instead of the products MRP sum,
        // prefer the real products MRP sum!
        if ($savedMrp > 0 && $calcMrp > $calcTotal && abs($savedMrp - $calcTotal) < 0.01) {
            return $calcMrp;
        }

        if ($savedMrp > 0) {
            return $savedMrp;
        }
        if ($calcMrp > 0 && $this->price && $calcMrp > $this->price) {
            return $calcMrp;
        }
        if ($calcTotal > 0 && $this->price && $calcTotal > $this->price) {
            return $calcTotal;
        }
        return null;
    }

    /**
     * Total package discount percentage
     */
    public function getDiscountPercentAttribute()
    {
        $mrp = $this->effective_mrp;
        $price = (float) $this->price;
        if ($mrp && $price && $mrp > $price) {
            return (int) round((($mrp - $price) / $mrp) * 100);
        }
        return 0;
    }

    /**
     * Total package savings amount
     */
    public function getSavingsAmountAttribute()
    {
        $mrp = $this->effective_mrp;
        $price = (float) $this->price;
        if ($mrp && $price && $mrp > $price) {
            return (float) ($mrp - $price);
        }
        return 0.0;
    }
}

