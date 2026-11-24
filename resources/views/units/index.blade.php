<x-stisla.dashboard.layout title="Unit">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar Unit">
        <div class="mb-3 text-right">
            <a href="{{ route('units.create') }}" class="btn btn-primary">Tambah Unit</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Kode Unit</th>
                        <th scope="col">Unit Induk</th>
                        <th scope="col">Nama Unit</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($units as $unit)
                        <tr>
                            <th scope="row">{{ $unit->kode_unit }}</th>
                            <td>{{ $unit->unitInduk->kode_unit_induk }} — {{ $unit->unitInduk->nama_unit_induk }}</td>
                            <td>{{ $unit->nama_unit }}</td>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('units.edit', $unit) }}" class="btn btn-outline-primary btn-sm"
                                    aria-label="Ubah Unit {{ $unit->nama_unit }}">Ubah</a>
                                <form method="POST" action="{{ route('units.destroy', $unit) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus Unit ini?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        aria-label="Hapus Unit {{ $unit->nama_unit }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data Unit.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $units->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
