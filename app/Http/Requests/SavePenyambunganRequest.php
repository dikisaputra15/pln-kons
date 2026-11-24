<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePenyambunganRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'daya_awal' => ['required', 'string', 'max:255'],
            'daya_akhir' => ['required', 'string', 'max:255'],
            'perva' => ['bail', 'required', 'numeric', 'decimal:0,2', 'between:-999999.99,999999.99'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'required' => ':Attribute wajib diisi.',
            'string' => ':Attribute harus berupa teks.',
            'max.string' => ':Attribute maksimal :max karakter.',
            'perva.numeric' => 'Biaya per VA harus berupa angka.',
            'perva.decimal' => 'Biaya per VA maksimal dua angka desimal.',
            'perva.between' => 'Biaya per VA di luar rentang yang dapat disimpan.',
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'daya_awal' => 'Daya awal',
            'daya_akhir' => 'Daya akhir',
            'perva' => 'Biaya per VA',
        ];
    }
}
