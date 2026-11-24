<?php

namespace Tests\Feature;

use App\Models\Tarif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TarifControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_tarifs(): void
    {
        $this->get(route('tarifs.index'))->assertRedirectToRoute('login');
        $this->post(route('tarifs.store'), ['nama_tarif' => 'Rumah Tangga'])
            ->assertRedirectToRoute('login');

        $this->assertDatabaseEmpty(Tarif::class);
    }

    public function test_signed_in_users_can_manage_a_tarif_from_the_dashboard(): void
    {
        $this->actingAs(User::factory()->create());
        $data = ['nama_tarif' => 'Rumah Tangga'];

        $this->get(route('home'))->assertOk()->assertSee(route('tarifs.index'));
        $this->get(route('tarifs.index'))->assertOk()->assertSeeText('Belum ada data tarif.');
        $this->get(route('tarifs.create'))->assertOk()->assertSeeText('Tambah Tarif');

        $this->post(route('tarifs.store'), $data)->assertRedirectToRoute('tarifs.index');
        $tarif = Tarif::query()->sole();
        $this->assertDatabaseHas(Tarif::class, $data);
        $this->get(route('tarifs.index'))->assertOk()->assertSeeText($data['nama_tarif']);
        $this->get(route('tarifs.edit', $tarif))->assertOk()->assertSee($data['nama_tarif']);

        $data['nama_tarif'] = 'Rumah Tangga 1';
        $this->put(route('tarifs.update', $tarif), $data)->assertRedirectToRoute('tarifs.index');
        $this->assertDatabaseHas(Tarif::class, ['id' => $tarif->id, ...$data]);

        $this->delete(route('tarifs.destroy', $tarif))->assertRedirectToRoute('tarifs.index');
        $this->assertModelMissing($tarif);
        $this->get(route('tarifs.edit', $tarif))->assertNotFound();
    }

    public function test_tarif_name_is_required_and_limited_to_150_characters(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('tarifs.store'))
            ->assertSessionHasErrors([
                'nama_tarif' => 'Nama tarif wajib diisi.',
            ]);

        $this->post(route('tarifs.store'), ['nama_tarif' => str_repeat('a', 151)])
            ->assertSessionHasErrors(['nama_tarif' => 'Nama tarif maksimal 150 karakter.']);

        $this->assertDatabaseEmpty(Tarif::class);
    }
}
