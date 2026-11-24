<?php

namespace Tests\Feature;

use App\Models\Jenispekerjaan;
use App\Models\Kategori;
use App\Models\Subjenispekerjaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjenispekerjaanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_subjenis_pekerjaan(): void
    {
        $this->get(route('subjenispekerjaans.index'))->assertRedirectToRoute('login');
        $this->post(route('subjenispekerjaans.store'))->assertRedirectToRoute('login');
    }

    public function test_signed_in_users_can_manage_subjenis_pekerjaan_from_the_master_menu(): void
    {
        $this->actingAs(User::factory()->create());
        $kategori = Kategori::query()->create(['kategori' => 'Instalasi']);
        $parent = Jenispekerjaan::query()->create(['id_kategori' => $kategori->id, 'jenis_pekerjaan' => 'Instalasi Kabel']);
        $data = ['id_jenis_pekerjaan' => $parent->id, 'subjenis_pekerjaan' => 'Pemasangan Kabel'];

        $this->get(route('home'))->assertOk()->assertSee(route('subjenispekerjaans.index'));
        $this->get(route('subjenispekerjaans.create'))->assertOk()->assertSeeText('Instalasi Kabel');
        $this->post(route('subjenispekerjaans.store'), $data)->assertRedirectToRoute('subjenispekerjaans.index');
        $this->assertDatabaseHas(Subjenispekerjaan::class, $data);

        $subjenisPekerjaan = $parent->subJenispekerjaan()->sole();
        $this->get(route('subjenispekerjaans.index'))->assertOk()->assertSeeTextInOrder(['Instalasi', 'Instalasi Kabel', 'Pemasangan Kabel']);
        $this->get(route('subjenispekerjaans.edit', $subjenisPekerjaan))->assertOk()
            ->assertSee('value="'.$parent->id.'" selected', false);

        $kategoriBaru = Kategori::query()->create(['kategori' => 'Perawatan']);
        $parentBaru = Jenispekerjaan::query()->create(['id_kategori' => $kategoriBaru->id, 'jenis_pekerjaan' => 'Pemeliharaan Kabel']);
        $data = ['id_jenis_pekerjaan' => $parentBaru->id, 'subjenis_pekerjaan' => 'Penggantian Kabel'];
        $this->put(route('subjenispekerjaans.update', $subjenisPekerjaan), $data)
            ->assertRedirectToRoute('subjenispekerjaans.index');
        $this->assertDatabaseHas(Subjenispekerjaan::class, ['id' => $subjenisPekerjaan->id, ...$data]);
        $this->get(route('subjenispekerjaans.index'))->assertOk()->assertSeeTextInOrder(['Perawatan', 'Pemeliharaan Kabel', 'Penggantian Kabel']);

        $this->delete(route('subjenispekerjaans.destroy', $subjenisPekerjaan))->assertRedirectToRoute('subjenispekerjaans.index');
        $this->assertModelMissing($subjenisPekerjaan);
    }

    public function test_subjenis_pekerjaan_requires_an_existing_jenis_pekerjaan_and_text_within_the_column_limit(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('subjenispekerjaans.create'))->assertOk()->assertSee(route('jenispekerjaans.create'));
        $this->post(route('subjenispekerjaans.store'), ['id_jenis_pekerjaan' => 999, 'subjenis_pekerjaan' => str_repeat('x', 256)])
            ->assertSessionHasErrors(['id_jenis_pekerjaan', 'subjenis_pekerjaan']);

        $this->assertDatabaseEmpty(Subjenispekerjaan::class);
    }
}
