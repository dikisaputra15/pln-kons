@php($title = $uid ? 'Ubah UID' : 'Tambah UID')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data UID">
                <form method="POST" action="{{ $uid ? route('uids.update', $uid) : route('uids.store') }}">
                    @csrf

                    @if ($uid)
                        @method('PUT')
                    @endif

                    <x-stisla.form-input name="kode_unit_induk" label="Kode Unit Induk" type="text"
                        :value="old('kode_unit_induk', $uid?->kode_unit_induk)" maxlength="150" required />

                    <x-stisla.form-input name="nama_unit_induk" label="Nama Unit Induk" type="text"
                        :value="old('nama_unit_induk', $uid?->nama_unit_induk)" maxlength="150" required />

                    <x-stisla.form-input name="bpp_kit" label="BPP KIT" type="number"
                        :value="old('bpp_kit', $uid?->bpp_kit)" min="-2147483648" max="2147483647" step="1" />

                    <x-stisla.form-input name="bpp_tt" label="BPP TT" type="number"
                        :value="old('bpp_tt', $uid?->bpp_tt)" min="-2147483648" max="2147483647" step="1" />

                    <x-stisla.form-input name="bpp_tr" label="BPP TR" type="number"
                        :value="old('bpp_tr', $uid?->bpp_tr)" min="-2147483648" max="2147483647" step="1" />

                    <x-stisla.form-input name="bpp_tr_plus_margin" label="BPP TR + Margin" type="number"
                        :value="old('bpp_tr_plus_margin', $uid?->bpp_tr_plus_margin)" min="-2147483648" max="2147483647" step="1" />

                    <x-stisla.form-input name="susut" label="Susut" type="number"
                        :value="old('susut', $uid?->susut)" min="-9999999999999.99" max="9999999999999.99" step="0.01" />

                    <x-stisla.form-input name="oem" label="OEM" type="number"
                        :value="old('oem', $uid?->oem)" min="-9999999999999.99" max="9999999999999.99" step="0.01" />

                    <a href="{{ route('uids.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $uid ? 'Simpan Perubahan' : 'Simpan UID' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
