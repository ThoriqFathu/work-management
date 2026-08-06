<?php

namespace App\Http\Requests\WorkSessionOutput;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkSessionOutputRequest extends FormRequest
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
            ],

            'tipe' => [
                'required',
                Rule::in([
                    'file',
                    'link',
                    'text',
                ]),
            ],

            'value' => [
                'nullable',
                'string',
            ],

            'file' => [
                'nullable',
                'file',
                'max:10240', //10MB
            ],

            'catatan' => [
                'nullable',
                'string',
            ],

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->tipe === 'file' && !$this->hasFile('file')) {

                $validator->errors()->add(
                    'file',
                    'File wajib diupload.'
                );

            }

            if (
                in_array($this->tipe, ['link', 'text'])
                && blank($this->value)
            ) {

                $validator->errors()->add(
                    'value',
                    'Value wajib diisi.'
                );

            }

        });
    }
}