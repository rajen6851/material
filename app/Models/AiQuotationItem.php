<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiQuotationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'ai_quotation_id',
        'product_id',
        'product_name',
        'sku',
        'unit_type',
        'unit_price',
        'quantity',
        'gst_percent',
        'total_price',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'quantity' => 'integer',
        'gst_percent' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function quotation()
    {
        return $this->belongsTo(AiQuotation::class, 'ai_quotation_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
