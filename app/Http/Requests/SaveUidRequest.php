<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUidRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        $text = ['required', 'string', 'max:150'];
        $integer = ['bail', 'nullable', 'integer', 'between:-2147483648,2147483647'];
        $decimal = ['bail', 'nullable', 'numeric', 'decimal:0,2', 'between:-9999999999999.99,9999999999999.99'];

        return [
            'kode_unit_induk' => $text,
            'nama_unit_induk' => $text,
            'bpp_kit' => $integer,
            'bpp_tt' => $integer,
            'bpp_tr' => $integer,
            'bpp_tr_plus_margin' => $integer,
            'susut' => $decimal,
            'oem' => $decimal,
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'required' => ':Attribute wajib diisi.',
            'string' => ':Attribute harus berupa teks.',
            'max.string' => ':Attribute maksimal :max karakter.',
            'integer' => ':Attribute harus berupa bilangan bulat.',
            'numeric' => ':Attribute harus berupa angka.',
            'decimal' => ':Attribute maksimal dua angka desimal.',
            'between.numeric' => ':Attribute di luar rentang yang dapat disimpan.',
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'kode_unit_induk' => 'Kode unit induk',
            'nama_unit_induk' => 'Nama unit induk',
            'bpp_kit' => 'BPP KIT',
            'bpp_tt' => 'BPP TT',
            'bpp_tr' => 'BPP TR',
            'bpp_tr_plus_margin' => 'BPP TR + Margin',
            'susut' => 'Susut',
            'oem' => 'OEM',
        ];
    }
}
