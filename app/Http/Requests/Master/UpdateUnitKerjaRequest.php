<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnitKerjaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('unit_kerja', 'nama')->ignore(
                    $this->route('unit_kerja')
                ),
            ],

            'aktif' => ['required', 'boolean'],
        ];
    }
}