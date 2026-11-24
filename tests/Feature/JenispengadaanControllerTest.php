<?php

namespace Tests\Feature;

use App\Models\Jenispengadaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JenispengadaanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_jenis_pengadaan(): void
    {
        $this->get(route('jenispengadaans.index'))->assertRedirectToRoute('login');
        $this->post(route('jenispengadaans.store'))->assertRedirectToRoute('login');
    }

    public function test_signed_in_users_can_manage_jenis_pengadaan_from_the_master_menu(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('home'))->assertOk()->assertSee(route('jenispengadaans.index'));
        $this->get(route('jenispengadaans.create'))->assertOk()->assertSee('name="jenis_pengadaan"', false);

        $this->post(route('jenispengadaans.store'), ['jenis_pengadaan' => 'Pengadaan Langsung'])
            ->assertRedirectToRoute('jenispengadaans.index');

        $jenisPengadaan = Jenispengadaan::query()->sole();
        $this->get(route('jenispengadaans.index'))->assertOk()->assertSeeText('Pengadaan Langsung');
        $this->get(route('jenispengadaans.edit', $jenisPengadaan))->assertOk()->assertSee('value="Pengadaan Langsung"', false);

        $this->put(route('jenispengadaans.update', $jenisPengadaan), ['jenis_pengadaan' => 'Tender Terbuka'])
            ->assertRedirectToRoute('jenispengadaans.index');
        $this->assertDatabaseHas(Jenispengadaan::class, ['id' => $jenisPengadaan->id, 'jenis_pengadaan' => 'Tender Terbuka']);

        $this->delete(route('jenispengadaans.destroy', $jenisPengadaan))->assertRedirectToRoute('jenispengadaans.index');
        $this->assertModelMissing($jenisPengadaan);
    }

    public function test_jenis_pengadaan_requires_text_within_the_column_limit(): void
    {
        $this->actingAs(User::factory()->create());

        foreach ([[], ['jenis_pengadaan' => ['Tender']], ['jenis_pengadaan' => str_repeat('x', 151)]] as $data) {
            $this->post(route('jenispengadaans.store'), $data)->assertSessionHasErrors('jenis_pengadaan');
        }

        $this->assertDatabaseEmpty(Jenispengadaan::class);
    }
}
