<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'judul' => 'required|max:255',

            'deskripsi' => 'nullable',

            'unit_kerja_id' => 'required|exists:unit_kerja,id',

            'requester_unit_id' => 'required|exists:requester_units,id',

            'category_id' => 'required|exists:categories,id',

            'priority_id' => 'required|exists:priorities,id',

            'status_id' => 'required|exists:statuses,id',

        ];
    }
}
