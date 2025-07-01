<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login berhasil dengan credential valid
     */
    public function test_user_dengan_credential_valid_dapat_login()
    {
        // Buat user dengan role admin
        $user = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin890'),
            'role' => 'admin',
        ]);

        // Kirim permintaan login
        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'admin890',
        ]);

        // Harus redirect ke dashboard
        $response->assertRedirect('/dashboard');

        // Harus terautentikasi sebagai user yang tadi dibuat
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login gagal jika password salah
     */
    public function test_user_dengan_password_salah_tidak_dapat_login()
    {
        // Buat user
        User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin890'),
            'role' => 'admin',
        ]);

        // Coba login dengan password salah
        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'salahpassword',
        ]);

        // Harus ada error (gagal login)
        $response->assertSessionHasErrors();
        $this->assertGuest(); // Harus belum login
    }

    /**
     * Test user yang belum login diarahkan ke login jika akses dashboard
     */
    public function test_user_tidak_bisa_akses_dashboard_jika_belum_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login'); // Redirect ke halaman login
    }
}
