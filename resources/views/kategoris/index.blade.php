<x-stisla.dashboard.layout title="Kategori">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar Kategori">
        <div class="mb-3 text-right">
            <a href="{{ route('kategoris.create') }}" class="btn btn-primary">Tambah Kategori</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Kategori</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoris as $kategori)
                        <tr>
                            <th scope="row">{{ $kategori->kategori }}</th>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('kategoris.edit', $kategori) }}" class="btn btn-outline-primary btn-sm"
                                    aria-label="Ubah Kategori {{ $kategori->kategori }}">Ubah</a>
                                <form method="POST" action="{{ route('kategoris.destroy', $kategori) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus Kategori ini?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        aria-label="Hapus Kategori {{ $kategori->kategori }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Belum ada data Kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $kategoris->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
