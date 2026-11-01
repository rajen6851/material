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
        if (!empty($this->attributes['mrp']) && $this->attributes['mrp'] > 0) {
            return (float) $this->attributes['mrp'];
        }
        $calcMrp = $this->calculated_mrp;
        if ($calcMrp > 0 && $this->price && $calcMrp > $this->price) {
            return (float) $calcMrp;
        }
        $calcTotal = $this->calculated_total;
        if ($calcTotal > 0 && $this->price && $calcTotal > $this->price) {
            return (float) $calcTotal;
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

