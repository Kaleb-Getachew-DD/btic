<?php
// FILE: app/Http/Requests/Admin/StoreProgramRequest.php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'title'             => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'full_description'  => 'nullable|string',
            'icon'              => 'nullable|string|max:100',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'duration'          => 'nullable|string|max:100',
            'eligibility'       => 'nullable|string|max:500',
            'benefits'          => 'nullable|string',
            'is_active'         => 'boolean',
            'sort_order'        => 'nullable|integer',
        ];
    }
}
