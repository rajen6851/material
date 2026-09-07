<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowroomVisit extends Model
{
    protected $fillable = [
        'user_id', 'name', 'mobile', 'role', 'purpose', 'visit_date', 'visit_time', 'status'
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
