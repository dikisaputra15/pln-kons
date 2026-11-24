@php($title = $kategori ? 'Ubah Kategori' : 'Tambah Kategori')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data Kategori">
                <form method="POST" action="{{ $kategori ? route('kategoris.update', $kategori) : route('kategoris.store') }}">
                    @csrf

                    @if ($kategori)
                        @method('PUT')
                    @endif

                    <x-stisla.form-input name="kategori" label="Nama Kategori" type="text"
                        :value="old('kategori', $kategori?->kategori)" maxlength="150" required />

                    <a href="{{ route('kategoris.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $kategori ? 'Simpan Perubahan' : 'Simpan Kategori' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
