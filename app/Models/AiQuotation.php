<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AiQuotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_number',
        'channel',
        'session_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_type',
        'delivery_address',
        'pincode',
        'subtotal',
        'tax_total',
        'discount_total',
        'grand_total',
        'customer_notes',
        'status',
        'approved_by_user_id',
        'approved_at',
        'rejection_reason',
        'admin_notes',
        'dispatch_status',
        'dispatch_payload',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'approved_at' => 'datetime',
        'dispatch_payload' => 'array',
    ];

    /**
     * Generate an aesthetic unique quotation number.
     */
    public static function generateQuoteNumber(): string
    {
        $prefix = 'PR-QT-' . date('Ymd');
        $random = strtoupper(Str::random(4));
        return "{$prefix}-{$random}";
    }

    public function items()
    {
        return $this->hasMany(AiQuotationItem::class, 'ai_quotation_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by_user_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'draft_pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isSent(): bool
    {
        return $this->status === 'sent';
    }
}
