<?php

namespace Tests\Feature;

use App\Models\Gi;
use App\Models\Uid;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_gis(): void
    {
        $this->get(route('gis.index'))->assertRedirectToRoute('login');
        $this->post(route('gis.store'))->assertRedirectToRoute('login');
    }

    public function test_signed_in_users_can_manage_gis_and_see_the_parent_unit(): void
    {
        $this->actingAs(User::factory()->create());
        $uid = Uid::query()->create(['kode_unit_induk' => 'UID01', 'nama_unit_induk' => 'Unit Induk Banten']);
        $unit = $uid->unit()->create(['kode_unit' => 'U01', 'nama_unit' => 'Unit Tangerang']);
        $data = ['id_unit' => $unit->id, 'nama_gi' => 'GI Cikokol'];

        $this->get(route('home'))->assertOk()->assertSee(route('gis.index'));
        $this->get(route('gis.create'))->assertOk()->assertSeeText('Unit Tangerang (Unit Induk Banten)');
        $this->post(route('gis.store'), $data)->assertRedirectToRoute('gis.index');
        $this->assertDatabaseHas(Gi::class, $data);

        $gi = $unit->gi()->sole();
        $this->get(route('gis.index'))->assertOk()->assertSeeTextInOrder(['GI Cikokol', 'UID01 — Unit Induk Banten', 'U01 — Unit Tangerang']);
        $this->get(route('gis.edit', $gi))->assertOk()->assertSee('value="'.$unit->id.'" selected', false);

        $otherUid = Uid::query()->create(['kode_unit_induk' => 'UID02', 'nama_unit_induk' => 'Unit Induk Jakarta']);
        $otherUnit = $otherUid->unit()->create(['kode_unit' => 'U02', 'nama_unit' => 'Unit Kebon Jeruk']);
        $this->put(route('gis.update', $gi), ['id_unit' => $otherUnit->id, 'nama_gi' => 'GI Kedoya'])
            ->assertRedirectToRoute('gis.index');
        $this->get(route('gis.index'))->assertOk()->assertSeeTextInOrder(['GI Kedoya', 'UID02 — Unit Induk Jakarta', 'U02 — Unit Kebon Jeruk']);

        $this->delete(route('gis.destroy', $gi))->assertRedirectToRoute('gis.index');
        $this->assertModelMissing($gi);
    }

    public function test_gi_requires_an_existing_unit_and_a_name_within_the_column_limit(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('gis.create'))->assertOk()->assertSee(route('units.create'));
        $this->post(route('gis.store'), ['id_unit' => 999, 'nama_gi' => str_repeat('X', 151)])
            ->assertSessionHasErrors(['id_unit', 'nama_gi']);

        $this->assertDatabaseEmpty(Gi::class);
    }
}
