<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class SaveRoleRequest extends FormRequest
{
    /** @return array<string, list<mixed>> */
    public function rules(): array
    {
        $name = Rule::unique(Role::class)->where('guard_name', 'web');

        if ($role = $this->route('role')) {
            $name->ignore($role);
        }

        return [
            'name' => ['bail', 'required', 'string', 'max:255', $name],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama role wajib diisi.',
            'name.string' => 'Nama role harus berupa teks.',
            'name.max' => 'Nama role maksimal :max karakter.',
            'name.unique' => 'Nama role sudah digunakan.',
        ];
    }
}
