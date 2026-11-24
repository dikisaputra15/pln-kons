@php($title = $satuan ? 'Ubah Satuan' : 'Tambah Satuan')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data Satuan">
                <form method="POST" action="{{ $satuan ? route('satuans.update', $satuan) : route('satuans.store') }}">
                    @csrf

                    @if ($satuan)
                        @method('PUT')
                    @endif

                    <x-stisla.form-input name="nama_satuan" label="Nama Satuan" type="text"
                        :value="old('nama_satuan', $satuan?->nama_satuan)" maxlength="150" required />

                    <a href="{{ route('satuans.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $satuan ? 'Simpan Perubahan' : 'Simpan Satuan' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
