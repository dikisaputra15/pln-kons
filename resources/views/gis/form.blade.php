@php($title = $gi ? 'Ubah GI' : 'Tambah GI')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data GI">
                <form method="POST" action="{{ $gi ? route('gis.update', $gi) : route('gis.store') }}">
                    @csrf

                    @if ($gi)
                        @method('PUT')
                    @endif

                    @if ($units->isEmpty())
                        <div class="alert alert-info">
                            Tambahkan <a href="{{ route('units.create') }}">Unit</a> terlebih dahulu agar bisa membuat GI.
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
                                <option value="{{ $unit->id }}" @selected(old('id_unit', $gi?->id_unit) == $unit->id)>
                                    {{ $unit->kode_unit }} — {{ $unit->nama_unit }} ({{ $unit->unitInduk->nama_unit_induk }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_unit')
                            <div id="id_unit-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-stisla.form-input name="nama_gi" label="Nama GI" type="text"
                        :value="old('nama_gi', $gi?->nama_gi)" maxlength="150" required />

                    <a href="{{ route('gis.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary" @disabled($units->isEmpty())>
                        {{ $gi ? 'Simpan Perubahan' : 'Simpan GI' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
