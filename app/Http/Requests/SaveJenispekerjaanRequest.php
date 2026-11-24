<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveJenispekerjaanRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'id_kategori' => ['bail', 'required', 'integer', 'exists:kategoris,id'],
            'jenis_pekerjaan' => ['required', 'string', 'max:150'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'required' => ':Attribute wajib diisi.',
            'string' => ':Attribute harus berupa teks.',
            'max.string' => ':Attribute maksimal :max karakter.',
            'id_kategori.integer' => 'Pilihan Kategori tidak valid.',
            'id_kategori.exists' => 'Kategori yang dipilih tidak ditemukan.',
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'id_kategori' => 'Kategori',
            'jenis_pekerjaan' => 'Jenis pekerjaan',
        ];
    }
}
