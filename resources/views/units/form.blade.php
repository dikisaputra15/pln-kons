@php($title = $unit ? 'Ubah Unit' : 'Tambah Unit')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data Unit">
                <form method="POST" action="{{ $unit ? route('units.update', $unit) : route('units.store') }}">
                    @csrf

                    @if ($unit)
                        @method('PUT')
                    @endif

                    @if ($uids->isEmpty())
                        <div class="alert alert-info">
                            Tambahkan <a href="{{ route('uids.create') }}">UID</a> terlebih dahulu agar bisa memilih unit induk.
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="id_unit_induk">Unit Induk</label>
                        <select id="id_unit_induk" name="id_unit_induk"
                            @class(['form-control', 'is-invalid' => $errors->has('id_unit_induk')])
                            @error('id_unit_induk') aria-invalid="true" aria-describedby="id_unit_induk-error" @enderror
                            required>
                            <option value="">Pilih Unit Induk</option>
                            @foreach ($uids as $uid)
                                <option value="{{ $uid->id }}" @selected(old('id_unit_induk', $unit?->id_unit_induk) == $uid->id)>
                                    {{ $uid->kode_unit_induk }} — {{ $uid->nama_unit_induk }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_unit_induk')
                            <div id="id_unit_induk-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-stisla.form-input name="kode_unit" label="Kode Unit" type="text"
                        :value="old('kode_unit', $unit?->kode_unit)" maxlength="150" required />

                    <x-stisla.form-input name="nama_unit" label="Nama Unit" type="text"
                        :value="old('nama_unit', $unit?->nama_unit)" maxlength="150" required />

                    <a href="{{ route('units.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary" @disabled($uids->isEmpty())>
                        {{ $unit ? 'Simpan Perubahan' : 'Simpan Unit' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
