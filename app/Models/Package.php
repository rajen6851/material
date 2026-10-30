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
        return $this->hasMany(PackageItem::class)->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
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
    public function getCalculatedTotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return ($item->price ?? 0) * ($item->quantity ?? 1);
        });
    }
}

