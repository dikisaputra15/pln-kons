<x-stisla.dashboard.layout title="User">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar User">
        <div class="mb-3 text-right">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah User</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">NIP</th>
                        <th scope="col">Email</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Roles</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->name }}</th>
                            <td>{{ $user->username ?? '—' }}</td>
                            <td>{{ $user->nip ?? '—' }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->unit?->nama_unit ?? '—' }}</td>
                            <td>{{ $user->roles->pluck('name')->sort()->join(', ') ?: '—' }}</td>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary btn-sm"
                                    aria-label="Ubah User {{ $user->name }}">Ubah</a>
                                @if (! $user->is(auth()->user()))
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline"
                                        onsubmit="return confirm('Hapus User ini?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                            aria-label="Hapus User {{ $user->name }}">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data User.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
