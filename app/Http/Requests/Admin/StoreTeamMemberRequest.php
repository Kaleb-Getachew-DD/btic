<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamMemberRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'title'      => 'required|string|max:255',
            'bio'        => 'nullable|string',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'email'      => 'nullable|email',
            'phone'      => 'nullable|string|max:20',
            'linkedin'   => 'nullable|url',
            'twitter'    => 'nullable|url',
            'department' => 'nullable|string|max:100',
            'is_active'  => 'boolean',
            'sort_order' => 'nullable|integer',
        ];
    }
}
