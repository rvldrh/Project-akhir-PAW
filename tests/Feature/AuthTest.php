<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_can_login_with_valid_credentials(): void
    {
        $mahasiswa = Pengguna::create([
            'identitas_akun' => '215150200111001',
            'nama' => 'Mahasiswa Test',
            'kredensial' => Hash::make('password123'),
            'peran' => 'mahasiswa',
            'status_akun' => 'Aktif',
        ]);

        $response = $this->post(route('login.attempt'), [
            'identitas_akun' => '215150200111001',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($mahasiswa);
    }

    public function test_satpam_can_login_with_kredensial_field_name(): void
    {
        $satpam = Pengguna::create([
            'identitas_akun' => '198001012005011001',
            'nama' => 'Satpam Test',
            'kredensial' => Hash::make('rahasiasatpam'),
            'peran' => 'satpam',
            'status_akun' => 'Aktif',
        ]);

        $response = $this->post(route('login.attempt'), [
            'identitas_akun' => '198001012005011001',
            'kredensial' => 'rahasiasatpam',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($satpam);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        Pengguna::create([
            'identitas_akun' => '215150200111002',
            'nama' => 'Mahasiswa Salah Password',
            'kredensial' => Hash::make('password_benar'),
            'peran' => 'mahasiswa',
            'status_akun' => 'Aktif',
        ]);

        $response = $this->from(route('login'))->post(route('login.attempt'), [
            'identitas_akun' => '215150200111002',
            'password' => 'password_salah',
        ]);

        $response->assertSessionHasErrors('identitas_akun');
        $this->assertGuest();
    }

    public function test_inactive_user_cannot_login(): void
    {
        Pengguna::create([
            'identitas_akun' => '215150200111003',
            'nama' => 'Akun Nonaktif',
            'kredensial' => Hash::make('password123'),
            'peran' => 'mahasiswa',
            'status_akun' => 'Nonaktif',
        ]);

        $response = $this->from(route('login'))->post(route('login.attempt'), [
            'identitas_akun' => '215150200111003',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['identitas_akun' => 'Akun Anda berstatus nonaktif. Silakan hubungi petugas.']);
        $this->assertGuest();
    }

    public function test_dashboard_redirects_satpam_to_satpam_dashboard(): void
    {
        $satpam = Pengguna::create([
            'identitas_akun' => '198001012005011002',
            'nama' => 'Satpam Dashboard',
            'kredensial' => Hash::make('password123'),
            'peran' => 'satpam',
            'status_akun' => 'Aktif',
        ]);

        $response = $this->actingAs($satpam)->get(route('dashboard'));

        $response->assertRedirect(route('satpam.dashboard'));
    }

    public function test_dashboard_redirects_mahasiswa_to_mahasiswa_dashboard(): void
    {
        $mahasiswa = Pengguna::create([
            'identitas_akun' => '215150200111004',
            'nama' => 'Mahasiswa Dashboard',
            'kredensial' => Hash::make('password123'),
            'peran' => 'mahasiswa',
            'status_akun' => 'Aktif',
        ]);

        $response = $this->actingAs($mahasiswa)->get(route('dashboard'));

        $response->assertRedirect(route('mahasiswa.dashboard'));
    }

    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $mahasiswa = Pengguna::create([
            'identitas_akun' => '215150200111005',
            'nama' => 'Mahasiswa Logout',
            'kredensial' => Hash::make('password123'),
            'peran' => 'mahasiswa',
            'status_akun' => 'Aktif',
        ]);

        $response = $this->actingAs($mahasiswa)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
