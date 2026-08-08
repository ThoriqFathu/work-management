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

            'url' => [
                'nullable',
                'url',
            ],

            'content' => [
                'nullable',
                'string',
            ],

            'file' => [
                'nullable',
                'file',
                'max:10240',
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
                $this->tipe === 'link'
                && blank($this->url)
            ) {

                $validator->errors()->add(
                    'url',
                    'URL wajib diisi.'
                );

            }

            if (
                $this->tipe === 'text'
                && blank($this->content)
            ) {

                $validator->errors()->add(
                    'content',
                    'Isi text wajib diisi.'
                );

            }

        });
    }
}