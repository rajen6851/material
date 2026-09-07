<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationRequest extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'quantity', 'address', 'remarks',
        'status', 'proposed_price', 'admin_remarks'
    ];

    protected $casts = [
        'proposed_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
