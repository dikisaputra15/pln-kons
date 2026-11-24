@php($title = $jenispekerjaan ? 'Ubah Jenis Pekerjaan' : 'Tambah Jenis Pekerjaan')

<x-stisla.dashboard.layout :title="$title">
    <div class="row">
        <div class="col-12 col-lg-7">
            <x-stisla.card title="Data Jenis Pekerjaan">
                <form method="POST" action="{{ $jenispekerjaan ? route('jenispekerjaans.update', $jenispekerjaan) : route('jenispekerjaans.store') }}">
                    @csrf

                    @if ($jenispekerjaan)
                        @method('PUT')
                    @endif

                    @if ($kategoris->isEmpty())
                        <div class="alert alert-info">
                            Tambahkan <a href="{{ route('kategoris.create') }}">Kategori</a> terlebih dahulu agar bisa membuat Jenis Pekerjaan.
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="id_kategori">Kategori</label>
                        <select id="id_kategori" name="id_kategori"
                            @class(['form-control', 'is-invalid' => $errors->has('id_kategori')])
                            @error('id_kategori') aria-invalid="true" aria-describedby="id_kategori-error" @enderror
                            required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('id_kategori', $jenispekerjaan?->id_kategori) == $kategori->id)>
                                    {{ $kategori->kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <div id="id_kategori-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-stisla.form-input name="jenis_pekerjaan" label="Jenis Pekerjaan" type="text"
                        :value="old('jenis_pekerjaan', $jenispekerjaan?->jenis_pekerjaan)" maxlength="150" required />

                    <a href="{{ route('jenispekerjaans.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary" @disabled($kategoris->isEmpty())>
                        {{ $jenispekerjaan ? 'Simpan Perubahan' : 'Simpan Jenis Pekerjaan' }}
                    </button>
                </form>
            </x-stisla.card>
        </div>
    </div>
</x-stisla.dashboard.layout>
