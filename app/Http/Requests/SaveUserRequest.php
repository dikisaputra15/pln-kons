<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Validator;
use Spatie\Permission\Models\Role;

class SaveUserRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if (is_string($this->input('email'))) {
            $this->merge(['email' => Str::lower($this->input('email'))]);
        }
    }

    /** @return array<string, list<mixed>> */
    public function rules(): array
    {
        $user = $this->route('user');
        $email = Rule::unique(User::class);

        if ($user) {
            $email->ignore($user);
        }

        return [
            'id_unit' => ['bail', 'required', 'integer', 'exists:units,id'],
            'username' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['bail', 'required', 'string', 'email', 'max:255', $email],
            'password' => [$user ? 'nullable' : 'required', 'string', Password::default(), 'confirmed'],
            'roles' => ['sometimes', 'array', 'list'],
            'roles.*' => ['bail', 'required', 'integer', 'distinct', Rule::exists(Role::class, 'id')->where('guard_name', 'web')],
        ];
    }

    /** @return list<callable(Validator): void> */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if (! $this->user()->is($this->route('user')) || $validator->errors()->isNotEmpty()) {
                    return;
                }

                $adminRole = $this->user()->roles->firstWhere('name', User::ADMIN_ROLE);

                if (! in_array($adminRole->getKey(), array_map('intval', $this->input('roles', [])), true)) {
                    $validator->errors()->add('roles', 'Role admin pada akun Anda sendiri wajib dipertahankan.');
                }
            },
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'required' => ':Attribute wajib diisi.',
            'string' => ':Attribute harus berupa teks.',
            'max.string' => ':Attribute maksimal :max karakter.',
            'email.email' => 'Alamat email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'id_unit.integer' => 'Pilihan Unit tidak valid.',
            'id_unit.exists' => 'Unit yang dipilih tidak ditemukan.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'roles.*.exists' => 'Role yang dipilih tidak tersedia.',
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'id_unit' => 'Unit',
            'name' => 'Nama',
            'password' => 'Kata sandi',
            'nip' => 'NIP',
        ];
    }
}
