<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class TrackApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reference_number' => ['required', 'string', 'max:32'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->reference_number) {
            $this->merge([
                'reference_number' => strtoupper(trim($this->reference_number)),
            ]);
        }
    }
}
