@php($title = $penyambungan ? 'Ubah Penyambungan' : 'Tambah Penyambungan')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data Penyambungan">
                <form method="POST" action="{{ $penyambungan ? route('penyambungans.update', $penyambungan) : route('penyambungans.store') }}">
                    @csrf

                    @if ($penyambungan)
                        @method('PUT')
                    @endif

                    <x-stisla.form-input name="daya_awal" label="Daya Awal" type="text"
                        :value="old('daya_awal', $penyambungan?->daya_awal)" maxlength="255" required />

                    <x-stisla.form-input name="daya_akhir" label="Daya Akhir" type="text"
                        :value="old('daya_akhir', $penyambungan?->daya_akhir)" maxlength="255" required />

                    <x-stisla.form-input name="perva" label="Biaya per VA" type="number"
                        :value="old('perva', $penyambungan?->perva)" min="-999999.99" max="999999.99" step="0.01" required />

                    <a href="{{ route('penyambungans.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $penyambungan ? 'Simpan Perubahan' : 'Simpan Penyambungan' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
