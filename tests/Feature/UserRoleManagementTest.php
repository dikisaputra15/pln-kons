<?php

namespace Tests\Feature;

use App\Models\Uid;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserRoleManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_management_is_reserved_for_web_admins(): void
    {
        $this->get(route('users.index'))->assertRedirectToRoute('login');
        $this->get(route('roles.index'))->assertRedirectToRoute('login');

        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('home'))->assertOk()->assertDontSee(route('users.index'))->assertDontSee(route('roles.index'));
        $this->get(route('users.index'))->assertForbidden();
        $this->get(route('roles.index'))->assertForbidden();
        $this->put(route('users.update', $user), ['roles' => [1]])->assertForbidden();
        $this->post(route('roles.store'), ['name' => 'admin'])->assertForbidden();
    }

    public function test_admin_can_manage_users_and_assign_multiple_roles(): void
    {
        $this->signInAsAdmin();
        $unit = $this->createUnit();
        $operator = Role::create(['name' => 'operator', 'guard_name' => 'web']);
        $reviewer = Role::create(['name' => 'reviewer', 'guard_name' => 'web']);
        $data = [
            'id_unit' => $unit->id,
            'username' => 'budi01',
            'nip' => '00123',
            'name' => 'Budi',
            'email' => 'BUDI@example.com',
            'password' => 'rencana-aman-23',
            'password_confirmation' => 'rencana-aman-23',
            'roles' => [(string) $operator->id, (string) $reviewer->id],
        ];

        $this->get(route('home'))->assertOk()->assertSee(route('users.index'))->assertSee(route('roles.index'));
        $this->get(route('users.create'))->assertOk()->assertSeeText('Unit Cikokol')->assertSeeText('operator');
        $this->post(route('users.store'), $data)->assertRedirectToRoute('users.index');

        $user = User::query()->where('email', 'budi@example.com')->sole();
        $this->assertDatabaseHas(User::class, ['id' => $user->id, 'id_unit' => $unit->id, 'username' => 'budi01', 'nip' => '00123']);
        $this->assertTrue(Hash::check($data['password'], $user->password));
        $this->assertEqualsCanonicalizing(['operator', 'reviewer'], $user->getRoleNames()->all());

        $this->get(route('users.index'))->assertOk()->assertSeeTextInOrder(['Budi', 'budi01', '00123', 'Unit Cikokol', 'operator, reviewer']);
        $this->get(route('users.edit', $user))->assertOk()->assertSee('value="'.$operator->id.'" checked', false);

        $this->put(route('users.update', $user), [
            ...$data, 'name' => 'Budi Santoso', 'password' => '', 'password_confirmation' => '', 'roles' => [$reviewer->id],
        ])->assertRedirectToRoute('users.index');
        $updated = $user->refresh();
        $this->assertSame('Budi Santoso', $updated->name);
        $this->assertTrue(Hash::check($data['password'], $updated->password));
        $this->assertSame(['reviewer'], $updated->getRoleNames()->all());

        $this->delete(route('users.destroy', $user))->assertRedirectToRoute('users.index');
        $this->assertModelMissing($user);
    }

    public function test_user_validation_and_admin_self_protection(): void
    {
        $admin = $this->signInAsAdmin();
        $unit = $this->createUnit();
        $otherGuardRole = Role::create(['name' => 'operator', 'guard_name' => 'api']);

        $this->post(route('users.store'), [
            'id_unit' => 999,
            'email' => $admin->email,
            'password' => 'rencana-aman-23',
            'password_confirmation' => 'berbeda',
            'roles' => [$otherGuardRole->id],
        ])->assertSessionHasErrors(['id_unit', 'username', 'nip', 'name', 'email', 'password', 'roles.0']);

        $data = [
            'id_unit' => $unit->id,
            'name' => $admin->name,
            'username' => 'admin01',
            'nip' => '001',
            'email' => $admin->email,
        ];
        $this->put(route('users.update', $admin), $data)->assertSessionHasErrors('roles');
        $this->put(route('users.update', $admin), [
            ...$data, 'roles' => $admin->roles->modelKeys(),
        ])->assertRedirectToRoute('users.index');
        $this->delete(route('users.destroy', $admin))->assertForbidden();

        $unit->delete();
        $this->assertNull($admin->refresh()->id_unit);
        $this->assertTrue($admin->hasRole(User::ADMIN_ROLE));
    }

    public function test_admin_can_manage_web_roles_and_the_admin_role_is_protected(): void
    {
        $admin = $this->signInAsAdmin();
        $systemRole = $admin->roles->sole();

        $this->get(route('roles.create'))->assertOk();
        $this->post(route('roles.store'), ['name' => 'operator'])->assertRedirectToRoute('roles.index');
        $role = Role::findByName('operator', 'web');

        $this->get(route('roles.index'))->assertOk()->assertSeeText('operator');
        $this->get(route('roles.edit', $role))->assertOk()->assertSee('value="operator"', false);
        $this->post(route('roles.store'), ['name' => 'operator'])->assertSessionHasErrors('name');
        $this->put(route('roles.update', $role), ['name' => 'reviewer'])->assertRedirectToRoute('roles.index');
        $this->assertDatabaseHas(Role::class, ['id' => $role->id, 'name' => 'reviewer', 'guard_name' => 'web']);
        $this->delete(route('roles.destroy', $role))->assertRedirectToRoute('roles.index');
        $this->assertModelMissing($role);

        $this->put(route('roles.update', $systemRole), ['name' => 'pengganti'])->assertForbidden();
        $this->delete(route('roles.destroy', $systemRole))->assertForbidden();
        $this->assertModelExists($systemRole);
    }

    private function signInAsAdmin(): User
    {
        $admin = User::factory()->create();
        $admin->assignRole(Role::findOrCreate(User::ADMIN_ROLE, 'web'));
        $this->actingAs($admin);

        return $admin;
    }

    private function createUnit(): Unit
    {
        $uid = Uid::query()->create([
            'kode_unit_induk' => '001',
            'nama_unit_induk' => 'Unit Induk Jakarta',
        ]);

        return $uid->unit()->create(['kode_unit' => '010', 'nama_unit' => 'Unit Cikokol']);
    }
}
