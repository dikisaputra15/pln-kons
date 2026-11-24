<x-stisla.dashboard.layout title="UID">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar UID">
        <div class="mb-3 text-right">
            <a href="{{ route('uids.create') }}" class="btn btn-primary">Tambah UID</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Kode Unit Induk</th>
                        <th scope="col">Nama Unit Induk</th>
                        <th scope="col" class="text-right">BPP KIT</th>
                        <th scope="col" class="text-right">BPP TT</th>
                        <th scope="col" class="text-right">BPP TR</th>
                        <th scope="col" class="text-right">BPP TR + Margin</th>
                        <th scope="col" class="text-right">Susut</th>
                        <th scope="col" class="text-right">OEM</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($uids as $uid)
                        <tr>
                            <th scope="row">{{ $uid->kode_unit_induk }}</th>
                            <td>{{ $uid->nama_unit_induk }}</td>
                            <td class="text-right">{{ $uid->bpp_kit ?? "—" }}</td>
                            <td class="text-right">{{ $uid->bpp_tt ?? "—" }}</td>
                            <td class="text-right">{{ $uid->bpp_tr ?? "—" }}</td>
                            <td class="text-right">{{ $uid->bpp_tr_plus_margin ?? "—" }}</td>
                            <td class="text-right">{{ $uid->susut ?? "—" }}</td>
                            <td class="text-right">{{ $uid->oem ?? "—" }}</td>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('uids.edit', $uid) }}" class="btn btn-outline-primary btn-sm"
                                    aria-label="Ubah UID {{ $uid->nama_unit_induk }}">Ubah</a>
                                <form method="POST" action="{{ route('uids.destroy', $uid) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus UID ini?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        aria-label="Hapus UID {{ $uid->nama_unit_induk }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data UID.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $uids->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
