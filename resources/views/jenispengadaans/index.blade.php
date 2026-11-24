<x-stisla.dashboard.layout title="Jenis Pengadaan">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar Jenis Pengadaan">
        <div class="mb-3 text-right">
            <a href="{{ route('jenispengadaans.create') }}" class="btn btn-primary">Tambah Jenis Pengadaan</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Jenis Pengadaan</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenispengadaans as $jenispengadaan)
                        <tr>
                            <th scope="row">{{ $jenispengadaan->jenis_pengadaan }}</th>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('jenispengadaans.edit', $jenispengadaan) }}" class="btn btn-outline-primary btn-sm"
                                    aria-label="Ubah Jenis Pengadaan {{ $jenispengadaan->jenis_pengadaan }}">Ubah</a>
                                <form method="POST" action="{{ route('jenispengadaans.destroy', $jenispengadaan) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus Jenis Pengadaan ini?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        aria-label="Hapus Jenis Pengadaan {{ $jenispengadaan->jenis_pengadaan }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Belum ada data Jenis Pengadaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $jenispengadaans->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
