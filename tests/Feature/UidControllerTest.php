<?php

namespace Tests\Feature;

use App\Models\Uid;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UidControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_uids(): void
    {
        $this->get(route('uids.index'))->assertRedirectToRoute('login');
        $this->post(route('uids.store'))->assertRedirectToRoute('login');
    }

    public function test_signed_in_users_can_manage_a_uid(): void
    {
        $this->actingAs(User::factory()->create());
        $data = [
            'kode_unit_induk' => '001',
            'nama_unit_induk' => 'Unit Induk Jakarta',
            'bpp_kit' => '1200',
            'bpp_tt' => '900',
            'bpp_tr' => '0',
            'bpp_tr_plus_margin' => '1500',
            'susut' => '12.30',
            'oem' => '0.25',
        ];

        $this->get(route('home'))->assertOk()->assertSee(route('uids.index'));
        $this->get(route('uids.create'))->assertOk()->assertSee('name="oem"', false);
        $this->post(route('uids.store'), $data)->assertRedirectToRoute('uids.index');
        $this->assertDatabaseHas(Uid::class, $data);

        $uid = Uid::query()->sole();
        $this->get(route('uids.index'))->assertOk()->assertSeeTextInOrder(['001', 'Unit Induk Jakarta', '12.30', '0.25']);
        $this->get(route('uids.edit', $uid))->assertOk()->assertSee('value="12.30"', false);

        $data['nama_unit_induk'] = 'Unit Induk Bali';
        $data['susut'] = '';
        $this->put(route('uids.update', $uid), $data)->assertRedirectToRoute('uids.index');
        $this->assertDatabaseHas(Uid::class, ['id' => $uid->id, 'nama_unit_induk' => 'Unit Induk Bali', 'susut' => null]);

        $this->delete(route('uids.destroy', $uid))->assertRedirectToRoute('uids.index');
        $this->assertModelMissing($uid);
    }

    public function test_uid_validates_required_fields_and_numeric_limits(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('uids.store'), [
            'bpp_kit' => '2147483648',
            'bpp_tt' => '1.5',
            'susut' => '1.234',
            'oem' => '10000000000000.00',
        ])->assertSessionHasErrors(['kode_unit_induk', 'nama_unit_induk', 'bpp_kit', 'bpp_tt', 'susut', 'oem']);

        $this->assertDatabaseEmpty(Uid::class);
    }
}
