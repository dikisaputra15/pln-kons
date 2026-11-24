<?php

namespace Tests\Feature;

use App\Models\Daya;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DayaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_daya(): void
    {
        $this->get(route('dayas.index'))->assertRedirectToRoute('login');
        $this->post(route('dayas.store'))->assertRedirectToRoute('login');
    }

    public function test_signed_in_users_can_manage_daya_linked_to_a_tarif(): void
    {
        $this->actingAs(User::factory()->create());
        $tarif = Tarif::query()->create(['nama_tarif' => 'Rumah Tangga']);
        $data = ['id_tarif' => $tarif->id, 'daya' => 1300, 'rp_tarif' => '1444.70'];

        $this->get(route('home'))->assertOk()->assertSee(route('dayas.index'));
        $this->get(route('dayas.create'))->assertOk()->assertSeeText('Rumah Tangga');
        $this->post(route('dayas.store'), $data)->assertRedirectToRoute('dayas.index');
        $this->assertDatabaseHas(Daya::class, $data);

        $daya = Daya::query()->sole();

        $this->get(route('dayas.index'))->assertOk()->assertSeeTextInOrder(['Rumah Tangga', '1.300', 'Rp 1.444,70']);
        $this->get(route('dayas.edit', $daya))->assertOk()->assertSee('value="'.$tarif->id.'" selected', false);

        $data['daya'] = 2200;
        $this->put(route('dayas.update', $daya), $data)->assertRedirectToRoute('dayas.index');
        $this->assertDatabaseHas(Daya::class, ['id' => $daya->id, ...$data]);

        $this->delete(route('dayas.destroy', $daya))->assertRedirectToRoute('dayas.index');
        $this->assertModelMissing($daya);
    }

    public function test_invalid_daya_is_rejected(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('dayas.create'))->assertOk()->assertSeeText('Belum ada tarif.');
        $this->post(route('dayas.store'), ['id_tarif' => 999, 'daya' => 0, 'rp_tarif' => '10.123'])
            ->assertSessionHasErrors([
                'id_tarif' => 'Tarif yang dipilih tidak tersedia.',
                'daya' => 'Daya minimal 1 VA.',
                'rp_tarif' => 'Nilai tarif dapat memiliki maksimal dua angka desimal.',
            ]);

        $this->assertDatabaseEmpty(Daya::class);
    }
}
