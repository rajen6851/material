<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomSpaceSubCategoryRequest extends FormRequest
{
    public function authorize()
    {
        // Assuming only admins can manage sub categories
        return auth()->check();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // max 2MB
            'slug' => 'nullable|string|unique:room_space_sub_categories,slug',
        ];
    }
}
