<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveKategoriRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'kategori' => ['required', 'string', 'max:150'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'kategori.required' => 'Nama kategori wajib diisi.',
            'kategori.string' => 'Nama kategori harus berupa teks.',
            'kategori.max' => 'Nama kategori maksimal :max karakter.',
        ];
    }
}
