@php($title = $user ? 'Ubah User' : 'Tambah User')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data User">
                <form method="POST" action="{{ $user ? route('users.update', $user) : route('users.store') }}">
                    @csrf

                    @if ($user)
                        @method('PUT')
                    @endif

                    @if ($units->isEmpty())
                        <div class="alert alert-info">
                            Tambahkan <a href="{{ route('units.create') }}">Unit</a> terlebih dahulu agar bisa memilih Unit.
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="id_unit">Unit</label>
                        <select id="id_unit" name="id_unit"
                            @class(['form-control', 'is-invalid' => $errors->has('id_unit')])
                            @error('id_unit') aria-invalid="true" aria-describedby="id_unit-error" @enderror
                            required>
                            <option value="">Pilih Unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" @selected(old('id_unit', $user?->id_unit) == $unit->id)>
                                    {{ $unit->kode_unit }} — {{ $unit->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_unit')
                            <div id="id_unit-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-stisla.form-input name="username" label="Username" type="text"
                        :value="old('username', $user?->username)" maxlength="255" required />

                    <x-stisla.form-input name="nip" label="NIP" type="text"
                        :value="old('nip', $user?->nip)" maxlength="255" required />

                    <x-stisla.form-input name="name" label="Nama" type="text"
                        :value="old('name', $user?->name)" maxlength="255" required />

                    <x-stisla.form-input name="email" label="Email" type="email"
                        :value="old('email', $user?->email)" maxlength="255" required />

                    @if ($user)
                        <p class="text-muted small">Kosongkan kata sandi dan konfirmasinya untuk mempertahankan kata sandi saat ini.</p>
                    @endif

                    <x-stisla.form-input name="password" label="Kata Sandi" type="password"
                        autocomplete="new-password" :required="! $user" />

                    <x-stisla.form-input name="password_confirmation" label="Konfirmasi Kata Sandi" type="password"
                        autocomplete="new-password" :required="! $user" />

                    <fieldset class="form-group">
                        <legend class="col-form-label">Role</legend>
                        @php($selectedRoles = session()->hasOldInput() ? old('roles', []) : $user?->roles->modelKeys() ?? [])
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" id="role-{{ $role->id }}" type="checkbox" name="roles[]"
                                    value="{{ $role->id }}" @checked(in_array($role->id, (array) $selectedRoles))>
                                <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        @endforeach
                        @foreach ($errors->get('roles*') as $messages)
                            @foreach ($messages as $message)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @endforeach
                        @endforeach
                    </fieldset>

                    <a href="{{ route('users.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary" @disabled($units->isEmpty())>
                        {{ $user ? 'Simpan Perubahan' : 'Simpan User' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
