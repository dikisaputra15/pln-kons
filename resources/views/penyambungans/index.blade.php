<x-stisla.dashboard.layout title="Penyambungan">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar Penyambungan">
        <div class="mb-3 text-right">
            <a href="{{ route('penyambungans.create') }}" class="btn btn-primary">Tambah Penyambungan</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Daya Awal</th>
                        <th scope="col">Daya Akhir</th>
                        <th scope="col" class="text-right">Biaya per VA</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penyambungans as $penyambungan)
                        <tr>
                            <th scope="row">{{ $penyambungan->daya_awal }}</th>
                            <td>{{ $penyambungan->daya_akhir }}</td>
                            <td class="text-right">{{ number_format((float) $penyambungan->perva, 2, ',', '.') }}</td>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('penyambungans.edit', $penyambungan) }}" class="btn btn-outline-primary btn-sm"
                                    aria-label="Ubah Penyambungan {{ $penyambungan->daya_awal }} ke {{ $penyambungan->daya_akhir }}">Ubah</a>
                                <form method="POST" action="{{ route('penyambungans.destroy', $penyambungan) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus Penyambungan ini?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        aria-label="Hapus Penyambungan {{ $penyambungan->daya_awal }} ke {{ $penyambungan->daya_akhir }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data Penyambungan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $penyambungans->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
