<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'            => 'required|string|max:255',
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'cover_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'category'         => 'nullable|string|max:100',
            'tags'             => 'nullable|string',
            'is_published'     => 'boolean',
            'is_featured'      => 'boolean',
            'published_at'     => 'nullable|date',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
        ];
    }
}
