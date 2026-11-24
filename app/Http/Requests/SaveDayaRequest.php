<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveDayaRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'id_tarif' => ['bail', 'required', 'integer', 'exists:tarifs,id'],
            'daya' => ['bail', 'required', 'integer', 'min:1', 'max:2147483647'],
            'rp_tarif' => ['bail', 'required', 'numeric', 'decimal:0,2', 'min:0', 'max:9999999999999.99'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'id_tarif.required' => 'Tarif wajib dipilih.',
            'id_tarif.integer' => 'Tarif yang dipilih tidak valid.',
            'id_tarif.exists' => 'Tarif yang dipilih tidak tersedia.',
            'daya.required' => 'Daya wajib diisi.',
            'daya.integer' => 'Daya harus berupa bilangan bulat.',
            'daya.min' => 'Daya minimal :min VA.',
            'daya.max' => 'Daya melebihi batas yang dapat disimpan.',
            'rp_tarif.required' => 'Nilai tarif wajib diisi.',
            'rp_tarif.numeric' => 'Nilai tarif harus berupa angka.',
            'rp_tarif.decimal' => 'Nilai tarif dapat memiliki maksimal dua angka desimal.',
            'rp_tarif.min' => 'Nilai tarif minimal Rp 0.',
            'rp_tarif.max' => 'Nilai tarif melebihi batas yang dapat disimpan.',
        ];
    }
}
