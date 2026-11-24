@php($title = $daya ? 'Ubah Daya' : 'Tambah Daya')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data Daya">
                <form method="POST" action="{{ $daya ? route('dayas.update', $daya) : route('dayas.store') }}">
                    @csrf

                    @if ($daya)
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="id_tarif" class="text-dark">Tarif</label>
                        <select id="id_tarif" name="id_tarif" @class(['form-control', 'is-invalid' => $errors->has('id_tarif')])
                            @error('id_tarif') aria-invalid="true" aria-describedby="id_tarif-error" @enderror required>
                            <option value="">Pilih tarif</option>
                            @foreach ($tarifs as $tarif)
                                <option value="{{ $tarif->id }}" @selected(old('id_tarif', $daya?->id_tarif) == $tarif->id)>
                                    {{ $tarif->nama_tarif }}
                                </option>
                            @endforeach
                        </select>

                        @error('id_tarif')
                            <div id="id_tarif-error" class="invalid-feedback" role="alert">{{ $message }}</div>
                        @enderror

                        @if ($tarifs->isEmpty())
                            <div class="form-text text-muted">Belum ada tarif. <a href="{{ route('tarifs.create') }}">Tambah tarif</a> untuk melanjutkan.</div>
                        @endif
                    </div>

                    <x-stisla.form-input name="daya" label="Daya (VA)" type="number"
                        :value="old('daya', $daya?->daya)" min="1" max="2147483647" step="1" required />

                    <x-stisla.form-input name="rp_tarif" label="Nilai Tarif (Rp)" type="number"
                        :value="old('rp_tarif', $daya?->rp_tarif)" min="0" max="9999999999999.99" step="0.01" required />

                    <a href="{{ route('dayas.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary" @disabled($tarifs->isEmpty())>
                        {{ $daya ? 'Simpan Perubahan' : 'Simpan Daya' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
