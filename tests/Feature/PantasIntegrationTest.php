<?php

namespace Tests\Feature;

use App\Models\DropPoint;
use App\Models\Edukasi;
use App\Models\Jadwal;
use App\Models\Laporan;
use App\Models\Rute;
use App\Models\RuteHarian;
use App\Models\User;
use App\Models\Wilayah;
use App\Services\DampakService;
use App\Services\KeterlambatanService;
use App\Services\NotifikasiService;
use App\Services\SurabayaBoundary;
use App\Support\IntegrationAudit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PantasIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private function account(string $role = 'warga'): User
    {
        $wilayah = Wilayah::firstOrCreate(['nama' => 'Tegalsari'], ['lat' => -7.27, 'lng' => 112.74, 'aktif' => true]);
        $user = User::factory()->create(['role' => $role, 'wilayah_id' => $wilayah->id]);
        if ($role === 'petugas') {
            $user->areaTugas()->attach($wilayah);
        }

        return $user;
    }

    public function test_public_pages_and_guest_redirects(): void
    {
        $this->assertSame([], app(IntegrationAudit::class)->routeIssues());
        foreach (['/', '/warga/login', '/warga/daftar', '/admin/login', '/admin/daftar', '/petugas/login', '/petugas/daftar'] as $url) {
            $this->get($url)->assertOk();
        }
        foreach (['warga/beranda', 'admin/dashboard', 'petugas/beranda'] as $url) {
            $this->get('/'.$url)->assertRedirect('/'.explode('/', $url)[0].'/login');
        }
    }

    public function test_warga_pages_and_ownership(): void
    {
        $user = $this->account();
        $this->actingAs($user);
        foreach (['beranda', 'laporan', 'laporan/buat', 'jadwal', 'edukasi', 'drop-point', 'profil', 'profil/edit', 'pengaturan', 'pengaturan/notifikasi', 'pengaturan/privasi', 'pengaturan/bantuan'] as $path) {
            $this->get('/warga/'.$path)->assertOk();
        }
        $report = $this->report($user);
        $this->get('/warga/laporan/'.$report->id)->assertOk();
        $this->actingAs($this->account())->get('/warga/laporan/'.$report->id)->assertForbidden();
    }

    private function report(User $user): Laporan
    {
        return Laporan::create(['user_id' => $user->id, 'wilayah_id' => $user->wilayah_id, 'judul' => 'Sampah perlu diangkut', 'kategori' => 'rumah_tangga', 'kondisi' => 'Tercampur', 'jumlah' => '1 kantong', 'lokasi_teks' => 'Tegalsari Surabaya', 'lat' => -7.27, 'lng' => 112.74, 'deskripsi' => 'Sampah menumpuk di dekat rumah.', 'foto_path' => 'laporan/test.jpg']);
    }

    public function test_admin_pages_and_report_update(): void
    {
        $warga = $this->account();
        $report = $this->report($warga);
        $admin = $this->account('admin');
        $this->actingAs($admin);
        foreach (['dashboard', 'pengguna', 'laporan', 'jadwal', 'jadwal/create', 'rute', 'rute/create', 'edukasi', 'edukasi/create', 'drop-point', 'drop-point/create', 'monitoring', 'aktivitas', 'profil', 'profil/edit'] as $path) {
            $this->get('/admin/'.$path)->assertOk();
        }
        $this->get('/admin/pengguna/'.$warga->id.'/edit')->assertOk();
        $this->get('/admin/laporan/'.$report->id)->assertOk();
        $this->patch('/admin/laporan/'.$report->id, ['status' => 'selesai', 'catatan' => 'Sudah dibersihkan'])->assertRedirect();
        $this->assertDatabaseHas('laporan', ['id' => $report->id, 'status' => 'selesai']);
        $this->assertDatabaseHas('laporan_riwayat', ['laporan_id' => $report->id, 'status' => 'selesai']);
        $this->assertDatabaseHas('notifikasi', ['user_id' => $warga->id, 'tipe' => 'laporan']);
    }

    public function test_petugas_home_without_and_with_route(): void
    {
        $user = $this->account('petugas');
        $this->actingAs($user)->get('/petugas/beranda')->assertOk()->assertDontSee('title="Belum tersedia"', false);
        $jadwal = Jadwal::create(['wilayah_id' => $user->wilayah_id, 'hari' => [today()->locale('id')->dayName], 'jam_mulai' => '06:00', 'jam_selesai' => '23:59', 'jenis_sampah' => 'Umum']);
        $rute = Rute::create(['kode' => 'RT-TEST', 'wilayah_id' => $user->wilayah_id, 'petugas_id' => $user->id, 'jadwal_id' => $jadwal->id]);
        $rute->titik()->create(['urutan' => 1, 'nama' => 'Titik pertama', 'jam_rencana' => '06:00', 'lat' => -7.27, 'lng' => 112.74]);
        $this->get('/petugas/beranda')->assertOk()->assertSee('RT-TEST');
        $this->post('/petugas/rute/mulai')->assertNotFound();
        $this->assertDatabaseCount('rute_harian', 0);
        $this->get('/petugas/beranda')->assertOk()->assertDontSee('action="'.url('/petugas/rute/mulai').'"', false)->assertSee('href="'.url('/petugas/rute').'"', false);
    }

    public function test_login_and_registration_each_portal(): void
    {
        foreach (['warga', 'admin', 'petugas'] as $role) {
            $user = $this->account($role);
            $this->post('/'.$role.'/login', ['email' => $user->email, 'password' => 'password'])->assertRedirect('/'.$role.($role === 'admin' ? '/dashboard' : '/beranda'));
            $this->assertAuthenticatedAs($user);
            $this->post('/'.$role.'/keluar')->assertRedirect('/'.$role.'/login');
            $this->post('/'.$role.'/daftar', ['nama' => 'Pengguna Uji', 'email' => $role.'@example.test', 'password' => 'password123', 'password_confirmation' => 'password123'])->assertSessionHasNoErrors()->assertRedirect('/'.$role.'/daftar/berhasil');
            $this->assertDatabaseHas('users', ['email' => $role.'@example.test', 'role' => $role, 'status' => $role === 'warga' ? 'aktif' : 'nonaktif']);
        }
    }

    public function test_warga_report_wizard_upload_and_notification(): void
    {
        Storage::fake('public');
        $user = $this->account();
        $this->actingAs($user);
        $this->post('/warga/laporan/foto', ['foto' => UploadedFile::fake()->image('sampah.jpg')])->assertSessionHasNoErrors()->assertRedirect('/warga/laporan/buat/detail');
        $this->get('/warga/laporan/buat/detail')->assertOk();
        $this->post('/warga/laporan/detail', ['judul' => 'Sampah di depan rumah', 'kategori' => 'rumah_tangga', 'kondisi' => config('laporan.kondisi')[0], 'jumlah' => '1 kantong', 'lokasi_teks' => 'Tegalsari, Surabaya', 'wilayah_id' => $user->wilayah_id, 'lat' => -7.27, 'lng' => 112.74, 'deskripsi' => 'Mohon diangkut karena sampah sudah menumpuk.'])->assertSessionHasNoErrors()->assertRedirect('/warga/laporan/buat/konfirmasi');
        $this->get('/warga/laporan/buat/konfirmasi')->assertOk();
        $this->post('/warga/laporan')->assertSessionHasNoErrors()->assertRedirect();
        $report = $user->laporan()->firstOrFail();
        Storage::disk('public')->assertExists($report->foto_path);
        $this->get('/warga/laporan/terkirim/'.$report->id)->assertOk();
        $this->assertDatabaseHas('laporan_riwayat', ['laporan_id' => $report->id, 'status' => 'baru']);
        $this->assertNull(session('laporan_draft'));
    }

    public function test_profile_password_privacy_and_notifications(): void
    {
        Storage::fake('public');
        $user = $this->account();
        $this->actingAs($user);
        $this->patch('/warga/profil', ['nama' => 'Nama Baru', 'wilayah_id' => $user->wilayah_id, 'alamat_lat' => -7.27, 'alamat_lng' => 112.74, 'avatar' => UploadedFile::fake()->image('avatar.jpg')])->assertSessionHasNoErrors()->assertRedirect('/warga/profil');
        $this->assertSame('Nama Baru', $user->fresh()->nama);
        Storage::disk('public')->assertExists($user->fresh()->avatar_path);
        $this->put('/warga/pengaturan/privasi', ['tampilkan_nama' => 1])->assertSessionHasNoErrors()->assertRedirect();
        $this->put('/warga/pengaturan/password', ['current_password' => 'password', 'password' => 'passwordBaru123', 'password_confirmation' => 'passwordBaru123'])->assertSessionHasNoErrors()->assertRedirect();
        $this->assertTrue(Hash::check('passwordBaru123', $user->fresh()->password));
        app(NotifikasiService::class)->send($user, 'Uji', 'Uji notifikasi', 'sistem', route('warga.jadwal'));
        $notification = $user->notifikasiAkun()->firstOrFail();
        $this->post('/warga/pengaturan/notifikasi/'.$notification->id)->assertRedirect('/warga/jadwal');
        $this->assertNotNull($notification->fresh()->dibaca_at);
        $this->actingAs($this->account())->post('/warga/pengaturan/notifikasi/'.$notification->id)->assertNotFound();
    }

    public function test_admin_resource_forms_persist_real_records(): void
    {
        $admin = $this->account('admin');
        $petugas = $this->account('petugas');
        $this->actingAs($admin);
        $schedule = ['wilayah_id' => $admin->wilayah_id, 'hari' => [today()->locale('id')->dayName], 'jam_mulai' => '06:00', 'jam_selesai' => '10:00', 'jenis_sampah' => 'Umum', 'status' => 'aktif'];
        $this->post('/admin/jadwal', $schedule)->assertSessionHasNoErrors()->assertRedirect('/admin/jadwal');
        $jadwal = Jadwal::firstOrFail();
        $route = ['wilayah_id' => $admin->wilayah_id, 'kode' => 'RTE-001', 'petugas_id' => $petugas->id, 'jadwal_id' => $jadwal->id, 'status' => 'aktif', 'titik' => [['nama' => 'Titik 1', 'jam_rencana' => '06:00', 'lat' => -7.27, 'lng' => 112.74], ['nama' => 'Titik 2', 'jam_rencana' => '07:00', 'lat' => -7.271, 'lng' => 112.741]]];
        $this->post('/admin/rute', $route)->assertSessionHasNoErrors()->assertRedirect('/admin/rute');
        $rute = Rute::firstOrFail();
        $this->assertSame(2, $rute->titik()->count());
        $this->get('/admin/rute/'.$rute->id.'/edit')->assertOk();
        $this->put('/admin/rute/'.$rute->id, $route)->assertSessionHasNoErrors()->assertRedirect();
        $this->post('/admin/edukasi', ['judul' => 'Cara memilah', 'audiens' => 'warga', 'kategori' => 'Pilah Sampah', 'status' => 'terbit', 'ringkasan' => 'Pisahkan sampah organik dan anorganik.'])->assertSessionHasNoErrors()->assertRedirect('/admin/edukasi');
        $edukasi = Edukasi::firstOrFail();
        $this->get('/admin/edukasi/'.$edukasi->id.'/edit')->assertOk();
        $this->post('/admin/drop-point', ['wilayah_id' => $admin->wilayah_id, 'nama' => 'Bank Sampah Uji', 'alamat' => 'Tegalsari', 'lat' => -7.27, 'lng' => 112.74, 'jam_buka' => '08:00', 'jam_tutup' => '16:00', 'hari_buka' => 'Senin-Sabtu', 'jenis_diterima' => 'Plastik', 'aktif' => 1])->assertSessionHasNoErrors()->assertRedirect('/admin/drop-point');
        $point = DropPoint::firstOrFail();
        $this->get('/admin/drop-point/'.$point->id.'/edit')->assertOk();
        $this->get('/admin/jadwal/'.$jadwal->id.'/edit')->assertOk();
        $this->get('/admin/pengguna/create')->assertOk();
        $this->post('/admin/pengguna', ['nama' => 'Warga Undangan', 'email' => 'undangan@example.test', 'role' => 'warga', 'status' => 'aktif', 'wilayah_id' => $admin->wilayah_id])->assertSessionHasNoErrors()->assertRedirect('/admin/pengguna');
        $this->actingAs($this->account())->get('/warga/edukasi/konten/'.$edukasi->id)->assertOk();
        $this->get('/warga/drop-point')->assertOk()->assertSee('Bank Sampah Uji');
    }

    public function test_delay_and_impact_use_persisted_data(): void
    {
        $this->travelTo(Carbon::parse('2026-11-16 09:00:00'));
        $this->assertSame(2, config('pantas.kg_per_kantong'));
        $this->assertSame(0.4, config('pantas.faktor_emisi'));
        $this->assertSame(10, config('pantas.ambang_terlambat_menit'));
        $warga = $this->account();
        $petugas = $this->account('petugas');
        $report = $this->report($warga);
        $report->update(['status' => 'selesai', 'selesai_at' => now()]);
        $impact = app(DampakService::class)->forUser($warga);
        $this->assertEquals(2, $impact['kg']);
        $this->assertEquals(0.8, $impact['emisi']);
        $rute = Rute::create(['kode' => 'RT-DELAY', 'petugas_id' => $petugas->id, 'wilayah_id' => $warga->wilayah_id]);
        $run = RuteHarian::create(['rute_id' => $rute->id, 'petugas_id' => $petugas->id, 'tanggal' => today(), 'mulai_at' => now()->subHours(2), 'status' => 'berjalan']);
        $run->titik()->create(['urutan' => 1, 'nama' => 'Titik terlambat', 'lat' => -7.27, 'lng' => 112.74, 'jam_rencana' => '08:00']);
        $this->assertSame(['kode' => 'RT-DELAY', 'menit' => 60], app(KeterlambatanService::class)->forUser($warga));
        app(KeterlambatanService::class)->forUser($warga);
        $this->assertSame(1, $warga->notifikasiAkun()->where('tipe', 'keterlambatan')->count());
        $this->actingAs($warga)->get('/warga/beranda')->assertOk()->assertSee('RT-DELAY');
        $this->travelBack();
    }

    public function test_validation_role_restrictions_and_petugas_home_only(): void
    {
        $warga = $this->account();
        $this->actingAs($warga)->get('/admin/dashboard')->assertForbidden();
        $this->post('/warga/laporan/foto', [])->assertSessionHasErrors('foto');
        $this->put('/warga/pengaturan/password', ['current_password' => 'salah', 'password' => 'passwordBaru123', 'password_confirmation' => 'passwordBaru123'])->assertSessionHasErrors('current_password');
        $this->assertTrue(Hash::check('password', $warga->fresh()->password));
        $this->actingAs($this->account('petugas'));
        foreach (['rute', 'rute/skema', 'profil', 'profil/edit', 'edukasi', 'laporan', 'pengaturan/bantuan', 'pengaturan/notifikasi', 'pengaturan/privasi'] as $path) {
            $this->get('/petugas/'.$path)->assertNotFound()->assertSee('Not Found')->assertDontSee('Halaman tidak ditemukan');
        }
        $warga->update(['status' => 'nonaktif']);
        $this->actingAs($warga);
        $this->get('/warga/beranda')->assertRedirect('/warga/login');
        $this->assertGuest();
    }

    public function test_boundary_assets_and_map_api_contract(): void
    {
        $boundary = app(SurabayaBoundary::class);
        $this->assertTrue($boundary->contains(-7.27, 112.74));
        $this->assertFalse($boundary->contains(-6.2, 106.8));
        foreach (['assets/landing.css', 'assets/css/admin.css', 'assets/css/warga.css', 'assets/css/petugas.css', 'assets/data/surabaya.geojson'] as $asset) {
            $this->assertFileExists(public_path($asset));
        }
        Http::preventStrayRequests();
        config(['maps.provider' => 'geoapify', 'maps.geoapify_api_key' => 'test-key']);
        Http::fake(['api.geoapify.com/*' => Http::response(['type' => 'FeatureCollection', 'features' => [['type' => 'Feature', 'geometry' => ['type' => 'Point', 'coordinates' => [112.74, -7.27]], 'properties' => ['formatted' => 'Tegalsari, Surabaya', 'district' => 'Tegalsari']]]])]);
        $this->actingAs($this->account())->getJson('/api/geocode/search?q=Tegalsari')->assertOk()->assertJsonPath('0.label', 'Tegalsari, Surabaya');
        $this->getJson('/api/geocode/reverse?lat=-7.27&lng=112.74')->assertOk()->assertJsonPath('0.lat', -7.27);
        $this->getJson('/api/geocode/search?q=a')->assertUnprocessable();
    }

    public function test_activation_and_admin_profile_update(): void
    {
        $user = $this->account();
        $user->update(['password_setup_required' => true]);
        $token = Password::broker()->createToken($user);
        $this->get('/aktivasi/'.$token.'?email='.urlencode($user->email))->assertOk();
        $payload = ['email' => $user->email, 'token' => $token, 'password' => 'aktivasi123', 'password_confirmation' => 'aktivasi123'];
        $this->post('/aktivasi', $payload)->assertSessionHasNoErrors()->assertRedirect('/warga/login');
        $this->assertFalse($user->fresh()->password_setup_required);
        $this->post('/aktivasi', $payload)->assertSessionHasErrors('email');
        $admin = $this->account('admin');
        $this->actingAs($admin)->patch('/admin/profil', ['nama' => 'Admin Baru', 'alamat' => 'Surabaya'])->assertSessionHasNoErrors()->assertRedirect('/admin/profil');
        $this->assertSame('Admin Baru', $admin->fresh()->nama);
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
