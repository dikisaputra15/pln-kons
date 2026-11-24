@php($title = $jenispengadaan ? 'Ubah Jenis Pengadaan' : 'Tambah Jenis Pengadaan')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data Jenis Pengadaan">
                <form method="POST" action="{{ $jenispengadaan ? route('jenispengadaans.update', $jenispengadaan) : route('jenispengadaans.store') }}">
                    @csrf

                    @if ($jenispengadaan)
                        @method('PUT')
                    @endif

                    <x-stisla.form-input name="jenis_pengadaan" label="Jenis Pengadaan" type="text"
                        :value="old('jenis_pengadaan', $jenispengadaan?->jenis_pengadaan)" maxlength="150" required />

                    <a href="{{ route('jenispengadaans.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $jenispengadaan ? 'Simpan Perubahan' : 'Simpan Jenis Pengadaan' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
