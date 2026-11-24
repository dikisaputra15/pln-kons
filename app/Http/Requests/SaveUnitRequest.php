<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUnitRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'id_unit_induk' => ['bail', 'required', 'integer', 'exists:uids,id'],
            'kode_unit' => ['required', 'string', 'max:150'],
            'nama_unit' => ['required', 'string', 'max:150'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'required' => ':Attribute wajib diisi.',
            'string' => ':Attribute harus berupa teks.',
            'max.string' => ':Attribute maksimal :max karakter.',
            'id_unit_induk.integer' => 'Pilihan unit induk tidak valid.',
            'id_unit_induk.exists' => 'Unit induk yang dipilih tidak ditemukan.',
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'id_unit_induk' => 'Unit induk',
            'kode_unit' => 'Kode unit',
            'nama_unit' => 'Nama unit',
        ];
    }
}
