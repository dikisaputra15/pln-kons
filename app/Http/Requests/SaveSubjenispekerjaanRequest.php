<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveSubjenispekerjaanRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'id_jenis_pekerjaan' => ['bail', 'required', 'integer', 'exists:jenispekerjaans,id'],
            'subjenis_pekerjaan' => ['required', 'string', 'max:255'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'required' => ':Attribute wajib diisi.',
            'string' => ':Attribute harus berupa teks.',
            'max.string' => ':Attribute maksimal :max karakter.',
            'id_jenis_pekerjaan.integer' => 'Pilihan jenis pekerjaan tidak valid.',
            'id_jenis_pekerjaan.exists' => 'Jenis pekerjaan yang dipilih tidak ditemukan.',
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'id_jenis_pekerjaan' => 'Jenis pekerjaan',
            'subjenis_pekerjaan' => 'Sub jenis pekerjaan',
        ];
    }
}
