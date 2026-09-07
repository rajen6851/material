<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomSpaceSubCategory extends Model
{
    use HasFactory;

    protected $table = 'room_space_sub_categories';

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'slug',
    ];

    // Accessor for image URL
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }
}
?>
