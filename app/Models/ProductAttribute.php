<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = ['type', 'value', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Available attribute types.
     */
    public const TYPES = [
        'collection'       => 'Collection',
        'material'         => 'Material',
        'finish'           => 'Finish',
        'pattern_type'     => 'Pattern Type',
        'edge_type'        => 'Edge Type',
        'application_area' => 'Application Area',
    ];

    /**
     * Get active values for a given type.
     */
    public static function getValues(string $type): array
    {
        return static::where('type', $type)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('value')
            ->pluck('value')
            ->toArray();
    }

    /**
     * Get all active values grouped by type (for product forms).
     */
    public static function getAllGrouped(): array
    {
        $grouped = [];
        foreach (array_keys(self::TYPES) as $type) {
            $grouped[$type] = static::getValues($type);
        }
        return $grouped;
    }
}
