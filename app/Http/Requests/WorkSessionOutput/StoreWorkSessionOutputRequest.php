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
        // dd([
        //     'all' => $this->all(),
        //     'content' => $this->input('content'),
        //     'tipe' => $this->input('tipe'),
        // ]);
        $validator->after(function ($validator) {

            if (
                $this->input('tipe') === 'file'
                && ! $this->hasFile('file')
            ) {
                $validator->errors()->add(
                    'file',
                    'File wajib diupload.'
                );
            }

            if (
                $this->input('tipe') === 'link'
                && blank($this->input('url'))
            ) {
                $validator->errors()->add(
                    'url',
                    'URL wajib diisi.'
                );
            }

            if (
                $this->input('tipe') === 'text'
                && blank($this->input('content'))
            ) {
                $validator->errors()->add(
                    'content',
                    'Isi text wajib diisi.'
                );
            }

        });
    }
}