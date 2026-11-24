<?php

namespace Tests\Feature;

use App\Models\Satuan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SatuanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_nama_satuan(): void
    {
        $this->get(route('satuans.index'))->assertRedirectToRoute('login');
        $this->post(route('satuans.store'))->assertRedirectToRoute('login');
    }

    public function test_signed_in_users_can_manage_nama_satuan_from_the_master_menu(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('home'))->assertOk()->assertSee(route('satuans.index'));
        $this->get(route('satuans.create'))->assertOk()->assertSee('name="nama_satuan"', false);

        $this->post(route('satuans.store'), ['nama_satuan' => 'Meter'])
            ->assertRedirectToRoute('satuans.index');

        $satuan = Satuan::query()->sole();
        $this->get(route('satuans.index'))->assertOk()->assertSeeText('Meter');
        $this->get(route('satuans.edit', $satuan))->assertOk()->assertSee('value="Meter"', false);

        $this->put(route('satuans.update', $satuan), ['nama_satuan' => 'Kilometer'])
            ->assertRedirectToRoute('satuans.index');
        $this->assertDatabaseHas(Satuan::class, ['id' => $satuan->id, 'nama_satuan' => 'Kilometer']);

        $this->delete(route('satuans.destroy', $satuan))->assertRedirectToRoute('satuans.index');
        $this->assertModelMissing($satuan);
    }

    public function test_nama_satuan_requires_text_within_the_column_limit(): void
    {
        $this->actingAs(User::factory()->create());

        foreach ([[], ['nama_satuan' => ['Meter']], ['nama_satuan' => str_repeat('x', 151)]] as $data) {
            $this->post(route('satuans.store'), $data)->assertSessionHasErrors('nama_satuan');
        }

        $this->assertDatabaseEmpty(Satuan::class);
    }
}
