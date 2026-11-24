<x-stisla.dashboard.layout title="Satuan">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar Satuan">
        <div class="mb-3 text-right">
            <a href="{{ route('satuans.create') }}" class="btn btn-primary">Tambah Satuan</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Satuan</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($satuans as $satuan)
                        <tr>
                            <th scope="row">{{ $satuan->nama_satuan }}</th>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('satuans.edit', $satuan) }}" class="btn btn-outline-primary btn-sm"
                                    aria-label="Ubah Satuan {{ $satuan->nama_satuan }}">Ubah</a>
                                <form method="POST" action="{{ route('satuans.destroy', $satuan) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus Satuan ini?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        aria-label="Hapus Satuan {{ $satuan->nama_satuan }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Belum ada data Satuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $satuans->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
