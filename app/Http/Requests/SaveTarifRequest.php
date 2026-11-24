<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveTarifRequest extends FormRequest
{
    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'nama_tarif' => ['required', 'string', 'max:150'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_tarif.required' => 'Nama tarif wajib diisi.',
            'nama_tarif.string' => 'Nama tarif harus berupa teks.',
            'nama_tarif.max' => 'Nama tarif maksimal :max karakter.',
        ];
    }
}
