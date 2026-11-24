<x-stisla.dashboard.layout title="Daya">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar Daya">
        <div class="mb-3 text-right">
            <a href="{{ route('dayas.create') }}" class="btn btn-primary">Tambah Daya</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Tarif</th>
                        <th scope="col">Daya (VA)</th>
                        <th scope="col">Nilai Tarif</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dayas as $daya)
                        <tr>
                            <th scope="row">{{ $daya->tarif?->nama_tarif ?? '—' }}</th>
                            <td>{{ number_format($daya->daya, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($daya->rp_tarif, 2, ',', '.') }}</td>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('dayas.edit', $daya) }}" class="btn btn-outline-primary btn-sm"
                                    aria-label="Ubah data daya {{ $daya->id }}">Ubah</a>
                                <form method="POST" action="{{ route('dayas.destroy', $daya) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus daya ini?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        aria-label="Hapus data daya {{ $daya->id }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data daya.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $dayas->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
