<?php

namespace Tests\Feature;

use App\Models\Uid;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnitControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_units(): void
    {
        $this->get(route('units.index'))->assertRedirectToRoute('login');
        $this->post(route('units.store'))->assertRedirectToRoute('login');
    }

    public function test_signed_in_users_can_manage_units_from_the_master_menu(): void
    {
        $this->actingAs(User::factory()->create());
        $uid = Uid::query()->create([
            'kode_unit_induk' => '001',
            'nama_unit_induk' => 'Unit Induk Jakarta',
        ]);
        $data = [
            'id_unit_induk' => $uid->id,
            'kode_unit' => '010',
            'nama_unit' => 'Unit Cikokol',
        ];

        $this->get(route('home'))->assertOk()->assertSee(route('units.index'));
        $this->get(route('units.create'))->assertOk()->assertSeeText('Unit Induk Jakarta');
        $this->post(route('units.store'), $data)->assertRedirectToRoute('units.index');
        $this->assertDatabaseHas(Unit::class, $data);

        $unit = $uid->unit()->sole();
        $this->get(route('units.index'))->assertOk()->assertSeeTextInOrder(['010', 'Unit Induk Jakarta', 'Unit Cikokol']);
        $this->get(route('units.edit', $unit))->assertOk()->assertSee('value="'.$uid->id.'" selected', false);

        $newUid = Uid::query()->create([
            'kode_unit_induk' => '002',
            'nama_unit_induk' => 'Unit Induk Banten',
        ]);
        $data['id_unit_induk'] = $newUid->id;
        $data['nama_unit'] = 'Unit Tangerang';
        $this->put(route('units.update', $unit), $data)->assertRedirectToRoute('units.index');
        $this->assertDatabaseHas(Unit::class, ['id' => $unit->id, ...$data]);

        $this->delete(route('units.destroy', $unit))->assertRedirectToRoute('units.index');
        $this->assertModelMissing($unit);
    }

    public function test_unit_requires_an_existing_parent_and_valid_text(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('units.create'))->assertOk()->assertSee(route('uids.create'));
        $this->post(route('units.store'), [
            'id_unit_induk' => 999,
            'kode_unit' => str_repeat('X', 151),
        ])->assertSessionHasErrors(['id_unit_induk', 'kode_unit', 'nama_unit']);

        $this->assertDatabaseEmpty(Unit::class);
    }
}
