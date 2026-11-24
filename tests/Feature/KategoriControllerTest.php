<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KategoriControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_kategori(): void
    {
        $this->get(route('kategoris.index'))->assertRedirectToRoute('login');
        $this->post(route('kategoris.store'))->assertRedirectToRoute('login');
    }

    public function test_signed_in_users_can_manage_kategori_from_the_master_menu(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('home'))->assertOk()->assertSee(route('kategoris.index'));
        $this->get(route('kategoris.create'))->assertOk()->assertSee('name="kategori"', false);

        $this->post(route('kategoris.store'), ['kategori' => 'Material'])
            ->assertRedirectToRoute('kategoris.index');

        $kategori = Kategori::query()->sole();
        $this->get(route('kategoris.index'))->assertOk()->assertSeeText('Material');
        $this->get(route('kategoris.edit', $kategori))->assertOk()->assertSee('value="Material"', false);

        $this->put(route('kategoris.update', $kategori), ['kategori' => 'Peralatan'])
            ->assertRedirectToRoute('kategoris.index');
        $this->assertDatabaseHas(Kategori::class, ['id' => $kategori->id, 'kategori' => 'Peralatan']);

        $this->delete(route('kategoris.destroy', $kategori))->assertRedirectToRoute('kategoris.index');
        $this->assertModelMissing($kategori);
    }

    public function test_kategori_requires_text_within_the_column_limit(): void
    {
        $this->actingAs(User::factory()->create());

        foreach ([[], ['kategori' => ['Material']], ['kategori' => str_repeat('x', 151)]] as $data) {
            $this->post(route('kategoris.store'), $data)->assertSessionHasErrors('kategori');
        }

        $this->assertDatabaseEmpty(Kategori::class);
    }
}
