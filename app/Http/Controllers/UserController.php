<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUserRequest;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        return view('users.index', [
            'users' => User::query()->with(['unit:id,kode_unit,nama_unit', 'roles'])->orderBy('name')->orderBy('id')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return $this->form(null);
    }

    public function store(SaveUserRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            $user = User::query()->create($request->safe()->except('roles'));
            $this->syncRoles($user, $request->validated('roles', []));
        });

        return redirect()->route('users.index')->with('status', 'User berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return $this->form($user->load('roles'));
    }

    public function update(SaveUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->safe()->except('roles');

        if (! $request->filled('password')) {
            unset($data['password']);
        }

        DB::transaction(function () use ($user, $data, $request): void {
            $user->fill($data);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();
            $this->syncRoles($user, $request->validated('roles', []));
        });

        return redirect()->route('users.index')->with('status', 'User berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        abort_if($user->is($request->user()), 403);

        $user->delete();

        return redirect()->route('users.index')->with('status', 'User berhasil dihapus.');
    }

    /** @param list<int|string> $roles */
    private function syncRoles(User $user, array $roles): void
    {
        $user->syncRoles(array_map('intval', $roles));
    }

    private function form(?User $user): View
    {
        return view('users.form', [
            'user' => $user,
            'units' => Unit::query()->orderBy('nama_unit')->orderBy('id')->get(['id', 'kode_unit', 'nama_unit']),
            'roles' => Role::query()->where('guard_name', 'web')->orderBy('name')->get(),
        ]);
    }
}
