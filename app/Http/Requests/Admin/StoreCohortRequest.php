<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCohortRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'batch_number'      => 'required|integer|min:1',
            'application_start' => 'required|date',
            'application_end'   => 'required|date|after:application_start',
            'program_start'     => 'nullable|date',
            'program_end'       => 'nullable|date|after:program_start',
            'max_startups'      => 'required|integer|min:1',
            'status'            => 'required|in:upcoming,open,closed,active,completed',
            'focus_areas'       => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ];
    }
}
