<?php
// FILE: app/Http/Requests/Admin/StoreStartupRequest.php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class StoreStartupRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'tagline'       => 'nullable|string|max:255',
            'description'   => 'required|string',
            'full_story'    => 'nullable|string',
            'sector'        => 'required|string|max:100',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'cover_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'founder_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'website'       => 'nullable|url',
            'email'         => 'nullable|email',
            'phone'         => 'nullable|string|max:20',
            'founded_year'  => 'nullable|string|max:4',
            'location'      => 'nullable|string|max:255',
            'founder_name'  => 'required|string|max:255',
            'founder_title' => 'nullable|string|max:255',
            'founder_bio'   => 'nullable|string',
            'team_size'     => 'nullable|integer|min:1',
            'stage'         => 'required|string|max:100',
            'cohort_batch'  => 'nullable|string|max:100',
            'linkedin'      => 'nullable|url',
            'twitter'       => 'nullable|url',
            'facebook'      => 'nullable|url',
            'achievements'  => 'nullable|string',
            'is_featured'   => 'boolean',
            'is_active'     => 'boolean',
            'sort_order'    => 'nullable|integer',
        ];
    }
}
