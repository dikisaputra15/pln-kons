<x-stisla.dashboard.layout title="Tarif">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar Tarif">
        <div class="mb-3 text-right">
            <a href="{{ route('tarifs.create') }}" class="btn btn-primary">Tambah Tarif</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nama Tarif</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tarifs as $tarif)
                        <tr>
                            <th scope="row">{{ $tarif->nama_tarif }}</th>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('tarifs.edit', $tarif) }}" class="btn btn-outline-primary btn-sm"
                                    aria-label="Ubah tarif {{ $tarif->nama_tarif }}">Ubah</a>
                                <form method="POST" action="{{ route('tarifs.destroy', $tarif) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus tarif ini beserta semua data daya yang terkait?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        aria-label="Hapus tarif {{ $tarif->nama_tarif }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Belum ada data tarif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $tarifs->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
