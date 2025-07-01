<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TanggapanTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_bisa_memberi_tanggapan()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pengaduan = Pengaduan::factory()->create();

        $response = $this->actingAs($admin)->post("/tanggapan/store/{$pengaduan->id}"
, [
            'isi_tanggapan' => 'Kami akan segera menindaklanjuti.',
        ]);

        $response->assertRedirect('/pengaduan');
        $this->assertDatabaseHas('tanggapans', [
            'pengaduan_id' => $pengaduan->id,
            'isi_tanggapan' => 'Kami akan segera menindaklanjuti.',
            'user_id' => $admin->id,
        ]);
    }

    public function test_tanggapan_tidak_bisa_kosong()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pengaduan = Pengaduan::factory()->create();

        $response = $this->actingAs($admin)->post("/tanggapan/store/{$pengaduan->id}", [
            'isi_tanggapan' => '',
        ]);

        $response->assertSessionHasErrors('isi_tanggapan');
    }

    public function test_mahasiswa_tidak_bisa_memberi_tanggapan()
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $pengaduan = Pengaduan::factory()->create();

        $response = $this->actingAs($mahasiswa)->post("/tanggapan/store/{$pengaduan->id}", [
            'isi_tanggapan' => 'Mahasiswa tidak boleh.',
        ]);

        $response->assertStatus(403);
    }
}
