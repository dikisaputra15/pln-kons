<x-stisla.dashboard.layout title="Role">
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <x-stisla.card title="Daftar Role">
        <div class="mb-3 text-right">
            <a href="{{ route('roles.create') }}" class="btn btn-primary">Tambah Role</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nama Role</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <th scope="row">{{ $role->name }}</th>
                            <td class="text-right text-nowrap">
                                @if ($role->name === \App\Models\User::ADMIN_ROLE)
                                    <span class="text-muted">Role sistem</span>
                                @else
                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-outline-primary btn-sm"
                                        aria-label="Ubah Role {{ $role->name }}">Ubah</a>
                                    <form method="POST" action="{{ route('roles.destroy', $role) }}" class="d-inline"
                                        onsubmit="return confirm('Hapus Role ini?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                            aria-label="Hapus Role {{ $role->name }}">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Belum ada data Role.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $roles->links('pagination::bootstrap-4') }}
    </x-stisla.card>
</x-stisla.dashboard.layout>
