<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveJenispengadaanRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'jenis_pengadaan' => ['required', 'string', 'max:150'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'jenis_pengadaan.required' => 'Jenis pengadaan wajib diisi.',
            'jenis_pengadaan.string' => 'Jenis pengadaan harus berupa teks.',
            'jenis_pengadaan.max' => 'Jenis pengadaan maksimal :max karakter.',
        ];
    }
}
