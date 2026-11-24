<x-stisla.dashboard.layout title="Sub Jenis Pekerjaan">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar Sub Jenis Pekerjaan">
        <div class="mb-3 text-right">
            <a href="{{ route('subjenispekerjaans.create') }}" class="btn btn-primary">Tambah Sub Jenis Pekerjaan</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Kategori</th>
                        <th scope="col">Jenis Pekerjaan</th>
                        <th scope="col">Sub Jenis Pekerjaan</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subjenispekerjaans as $subjenispekerjaan)
                        <tr>
                            <td>{{ $subjenispekerjaan->jenisPekerjaan->kategori->kategori }}</td>
                            <td>{{ $subjenispekerjaan->jenisPekerjaan->jenis_pekerjaan }}</td>
                            <th scope="row">{{ $subjenispekerjaan->subjenis_pekerjaan }}</th>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('subjenispekerjaans.edit', $subjenispekerjaan) }}" class="btn btn-outline-primary btn-sm"
                                    aria-label="Ubah Sub Jenis Pekerjaan {{ $subjenispekerjaan->subjenis_pekerjaan }}">Ubah</a>
                                <form method="POST" action="{{ route('subjenispekerjaans.destroy', $subjenispekerjaan) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus Sub Jenis Pekerjaan ini?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        aria-label="Hapus Sub Jenis Pekerjaan {{ $subjenispekerjaan->subjenis_pekerjaan }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data Sub Jenis Pekerjaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $subjenispekerjaans->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
