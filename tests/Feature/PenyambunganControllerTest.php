<?php

namespace Tests\Feature;

use App\Models\Penyambungan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenyambunganControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_penyambungan(): void
    {
        $this->get(route('penyambungans.index'))->assertRedirectToRoute('login');
        $this->post(route('penyambungans.store'))->assertRedirectToRoute('login');
    }

    public function test_signed_in_users_can_manage_penyambungan_from_the_master_menu(): void
    {
        $this->actingAs(User::factory()->create());
        $data = ['daya_awal' => '450 VA', 'daya_akhir' => '900 VA', 'perva' => '1250.50'];

        $this->get(route('home'))->assertOk()->assertSee(route('penyambungans.index'));
        $this->get(route('penyambungans.create'))->assertOk()->assertSee('name="perva"', false);
        $this->post(route('penyambungans.store'), $data)->assertRedirectToRoute('penyambungans.index');
        $this->assertDatabaseHas(Penyambungan::class, $data);

        $penyambungan = Penyambungan::query()->sole();
        $this->get(route('penyambungans.index'))->assertOk()->assertSeeTextInOrder(['450 VA', '900 VA', '1.250,50']);
        $this->get(route('penyambungans.edit', $penyambungan))->assertOk()->assertSee('value="1250.50"', false);

        $data = ['daya_awal' => '900 VA', 'daya_akhir' => '1.300 VA', 'perva' => '1400.25'];
        $this->put(route('penyambungans.update', $penyambungan), $data)
            ->assertRedirectToRoute('penyambungans.index');
        $this->assertDatabaseHas(Penyambungan::class, ['id' => $penyambungan->id, ...$data]);

        $this->delete(route('penyambungans.destroy', $penyambungan))->assertRedirectToRoute('penyambungans.index');
        $this->assertModelMissing($penyambungan);
    }

    public function test_penyambungan_validates_required_fields_and_column_limits(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('penyambungans.store'))->assertSessionHasErrors(['daya_awal', 'daya_akhir', 'perva']);
        $this->post(route('penyambungans.store'), [
            'daya_awal' => str_repeat('x', 256),
            'daya_akhir' => ['900 VA'],
            'perva' => '12.345',
        ])->assertSessionHasErrors(['daya_awal', 'daya_akhir', 'perva']);
        $this->post(route('penyambungans.store'), [
            'daya_awal' => '450 VA',
            'daya_akhir' => '900 VA',
            'perva' => '1000000.00',
        ])->assertSessionHasErrors('perva');

        $this->assertDatabaseEmpty(Penyambungan::class);
    }
}
