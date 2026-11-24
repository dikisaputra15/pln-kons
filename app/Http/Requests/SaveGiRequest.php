<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveGiRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'id_unit' => ['bail', 'required', 'integer', 'exists:units,id'],
            'nama_gi' => ['required', 'string', 'max:150'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'required' => ':Attribute wajib diisi.',
            'string' => ':Attribute harus berupa teks.',
            'max.string' => ':Attribute maksimal :max karakter.',
            'id_unit.integer' => 'Pilihan Unit tidak valid.',
            'id_unit.exists' => 'Unit yang dipilih tidak ditemukan.',
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'id_unit' => 'Unit',
            'nama_gi' => 'Nama GI',
        ];
    }
}
