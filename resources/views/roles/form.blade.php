@php($title = $role ? 'Ubah Role' : 'Tambah Role')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data Role">
                <form method="POST" action="{{ $role ? route('roles.update', $role) : route('roles.store') }}">
                    @csrf

                    @if ($role)
                        @method('PUT')
                    @endif

                    <x-stisla.form-input name="name" label="Nama Role" type="text"
                        :value="old('name', $role?->name)" maxlength="255" required />

                    <a href="{{ route('roles.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $role ? 'Simpan Perubahan' : 'Simpan Role' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
