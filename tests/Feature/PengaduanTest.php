<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PengaduanTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_bisa_membuat_pengaduan()
    {
        Storage::fake('public');
        $user = User::factory()->create(['role' => 'mahasiswa']);

        $response = $this->actingAs($user)->post('/pengaduan', [
            'judul' => 'AC Tidak Menyala',
            'isi_pengaduan' => 'AC di kelas rusak.',
            'bagian' => 'Sarana',
            'lampiran' => UploadedFile::fake()->create('dummy.pdf', 100, 'application/pdf'),
        ]);

        $response->assertRedirect('/pengaduan');
        $this->assertDatabaseHas('pengaduans', [
            'judul' => 'AC Tidak Menyala',
            'user_id' => $user->id,
        ]);
    }

    public function test_pengaduan_tidak_bisa_dikirim_tanpa_field_wajib()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);

        $response = $this->actingAs($user)->post('/pengaduan', [
            'judul' => '',
            'isi_pengaduan' => '',
            'bagian' => '',
        ]);

        $response->assertSessionHasErrors(['judul', 'isi_pengaduan', 'bagian']);
    }

    public function test_admin_bisa_melihat_semua_pengaduan()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        Pengaduan::factory()->create([
            'user_id' => $mahasiswa->id,
            'judul' => 'Internet Lemot',
        ]);

        $response = $this->actingAs($admin)->get('/pengaduan');

        $response->assertStatus(200);
        $response->assertSee('Internet Lemot');
    }
}
