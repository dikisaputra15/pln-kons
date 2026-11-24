<x-stisla.dashboard.layout title="GI">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar GI">
        <div class="mb-3 text-right">
            <a href="{{ route('gis.create') }}" class="btn btn-primary">Tambah GI</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nama GI</th>
                        <th scope="col">Unit Induk</th>
                        <th scope="col">Unit</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gis as $gi)
                        <tr>
                            <th scope="row">{{ $gi->nama_gi }}</th>
                            <td>{{ $gi->unit->unitInduk->kode_unit_induk }} — {{ $gi->unit->unitInduk->nama_unit_induk }}</td>
                            <td>{{ $gi->unit->kode_unit }} — {{ $gi->unit->nama_unit }}</td>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('gis.edit', $gi) }}" class="btn btn-outline-primary btn-sm"
                                    aria-label="Ubah GI {{ $gi->nama_gi }}">Ubah</a>
                                <form method="POST" action="{{ route('gis.destroy', $gi) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus GI ini?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        aria-label="Hapus GI {{ $gi->nama_gi }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data GI.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $gis->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
