<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveRoleRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('roles.index', [
            'roles' => Role::query()->where('guard_name', 'web')->orderBy('name')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('roles.form', ['role' => null]);
    }

    public function store(SaveRoleRequest $request): RedirectResponse
    {
        Role::create([...$request->validated(), 'guard_name' => 'web']);

        return redirect()->route('roles.index')->with('status', 'Role berhasil ditambahkan.');
    }

    public function edit(Role $role): View
    {
        $this->ensureEditable($role);

        return view('roles.form', ['role' => $role]);
    }

    public function update(SaveRoleRequest $request, Role $role): RedirectResponse
    {
        $this->ensureEditable($role);
        $role->update($request->validated());

        return redirect()->route('roles.index')->with('status', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $this->ensureEditable($role);
        $role->delete();

        return redirect()->route('roles.index')->with('status', 'Role berhasil dihapus.');
    }

    private function ensureEditable(Role $role): void
    {
        abort_unless($role->guard_name === 'web', 404);
        abort_if($role->name === User::ADMIN_ROLE, 403);
    }
}
