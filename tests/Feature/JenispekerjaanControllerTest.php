<?php

namespace Tests\Feature;

use App\Models\Jenispekerjaan;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JenispekerjaanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_jenis_pekerjaan(): void
    {
        $this->get(route('jenispekerjaans.index'))->assertRedirectToRoute('login');
        $this->post(route('jenispekerjaans.store'))->assertRedirectToRoute('login');
    }

    public function test_signed_in_users_can_manage_jenis_pekerjaan_from_the_master_menu(): void
    {
        $this->actingAs(User::factory()->create());
        $kategori = Kategori::query()->create(['kategori' => 'Instalasi']);
        $data = ['id_kategori' => $kategori->id, 'jenis_pekerjaan' => 'Pemasangan Kabel'];

        $this->get(route('home'))->assertOk()->assertSee(route('jenispekerjaans.index'));
        $this->get(route('jenispekerjaans.create'))->assertOk()->assertSeeText('Instalasi');
        $this->post(route('jenispekerjaans.store'), $data)->assertRedirectToRoute('jenispekerjaans.index');
        $this->assertDatabaseHas(Jenispekerjaan::class, $data);

        $jenisPekerjaan = Jenispekerjaan::query()->sole();
        $this->get(route('jenispekerjaans.index'))->assertOk()->assertSeeTextInOrder(['Instalasi', 'Pemasangan Kabel']);
        $this->get(route('jenispekerjaans.edit', $jenisPekerjaan))->assertOk()
            ->assertSee('value="'.$kategori->id.'" selected', false);

        $kategoriBaru = Kategori::query()->create(['kategori' => 'Pemeliharaan']);
        $data = ['id_kategori' => $kategoriBaru->id, 'jenis_pekerjaan' => 'Penggantian Kabel'];
        $this->put(route('jenispekerjaans.update', $jenisPekerjaan), $data)
            ->assertRedirectToRoute('jenispekerjaans.index');
        $this->assertDatabaseHas(Jenispekerjaan::class, ['id' => $jenisPekerjaan->id, ...$data]);
        $this->get(route('jenispekerjaans.index'))->assertOk()->assertSeeTextInOrder(['Pemeliharaan', 'Penggantian Kabel']);

        $this->delete(route('jenispekerjaans.destroy', $jenisPekerjaan))->assertRedirectToRoute('jenispekerjaans.index');
        $this->assertModelMissing($jenisPekerjaan);
    }

    public function test_jenis_pekerjaan_requires_an_existing_kategori_and_text_within_the_column_limit(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('jenispekerjaans.create'))->assertOk()->assertSee(route('kategoris.create'));
        $this->post(route('jenispekerjaans.store'), ['id_kategori' => 999, 'jenis_pekerjaan' => str_repeat('x', 151)])
            ->assertSessionHasErrors(['id_kategori', 'jenis_pekerjaan']);

        $this->assertDatabaseEmpty(Jenispekerjaan::class);
    }
}
