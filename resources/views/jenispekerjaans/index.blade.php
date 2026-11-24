<x-stisla.dashboard.layout title="Jenis Pekerjaan">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar Jenis Pekerjaan">
        <div class="mb-3 text-right">
            <a href="{{ route('jenispekerjaans.create') }}" class="btn btn-primary">Tambah Jenis Pekerjaan</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Kategori</th>
                        <th scope="col">Jenis Pekerjaan</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenispekerjaans as $jenispekerjaan)
                        <tr>
                            <td>{{ $jenispekerjaan->kategori->kategori }}</td>
                            <th scope="row">{{ $jenispekerjaan->jenis_pekerjaan }}</th>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('jenispekerjaans.edit', $jenispekerjaan) }}" class="btn btn-outline-primary btn-sm"
                                    aria-label="Ubah Jenis Pekerjaan {{ $jenispekerjaan->jenis_pekerjaan }}">Ubah</a>
                                <form method="POST" action="{{ route('jenispekerjaans.destroy', $jenispekerjaan) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus Jenis Pekerjaan ini?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        aria-label="Hapus Jenis Pekerjaan {{ $jenispekerjaan->jenis_pekerjaan }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada data Jenis Pekerjaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $jenispekerjaans->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
