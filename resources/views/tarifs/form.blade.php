@php($title = $tarif ? 'Ubah Tarif' : 'Tambah Tarif')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data Tarif">
                <form method="POST" action="{{ $tarif ? route('tarifs.update', $tarif) : route('tarifs.store') }}">
                    @csrf

                    @if ($tarif)
                        @method('PUT')
                    @endif

                    <x-stisla.form-input name="nama_tarif" label="Nama Tarif" type="text"
                        :value="old('nama_tarif', $tarif?->nama_tarif)" maxlength="150" required />

                    <a href="{{ route('tarifs.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $tarif ? 'Simpan Perubahan' : 'Simpan Tarif' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
