<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveSatuanRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'nama_satuan' => ['required', 'string', 'max:150'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'nama_satuan.required' => 'Nama satuan wajib diisi.',
            'nama_satuan.string' => 'Nama satuan harus berupa teks.',
            'nama_satuan.max' => 'Nama satuan maksimal :max karakter.',
        ];
    }
}
