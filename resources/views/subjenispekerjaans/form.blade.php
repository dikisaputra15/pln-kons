@php($title = $subjenispekerjaan ? 'Ubah Sub Jenis Pekerjaan' : 'Tambah Sub Jenis Pekerjaan')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data Sub Jenis Pekerjaan">
                <form method="POST" action="{{ $subjenispekerjaan ? route('subjenispekerjaans.update', $subjenispekerjaan) : route('subjenispekerjaans.store') }}">
                    @csrf

                    @if ($subjenispekerjaan)
                        @method('PUT')
                    @endif

                    @if ($jenispekerjaans->isEmpty())
                        <div class="alert alert-info">
                            Tambahkan <a href="{{ route('jenispekerjaans.create') }}">Jenis Pekerjaan</a> terlebih dahulu agar bisa membuat Sub Jenis Pekerjaan.
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="id_jenis_pekerjaan">Jenis Pekerjaan</label>
                        <select id="id_jenis_pekerjaan" name="id_jenis_pekerjaan"
                            @class(['form-control', 'is-invalid' => $errors->has('id_jenis_pekerjaan')])
                            @error('id_jenis_pekerjaan') aria-invalid="true" aria-describedby="id_jenis_pekerjaan-error" @enderror
                            required>
                            <option value="">Pilih Jenis Pekerjaan</option>
                            @foreach ($jenispekerjaans as $jenisPekerjaan)
                                <option value="{{ $jenisPekerjaan->id }}" @selected(old('id_jenis_pekerjaan', $subjenispekerjaan?->id_jenis_pekerjaan) == $jenisPekerjaan->id)>
                                    {{ $jenisPekerjaan->jenis_pekerjaan }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_jenis_pekerjaan')
                            <div id="id_jenis_pekerjaan-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-stisla.form-input name="subjenis_pekerjaan" label="Sub Jenis Pekerjaan" type="text"
                        :value="old('subjenis_pekerjaan', $subjenispekerjaan?->subjenis_pekerjaan)" maxlength="255" required />

                    <a href="{{ route('subjenispekerjaans.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary" @disabled($jenispekerjaans->isEmpty())>
                        {{ $subjenispekerjaan ? 'Simpan Perubahan' : 'Simpan Sub Jenis Pekerjaan' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
