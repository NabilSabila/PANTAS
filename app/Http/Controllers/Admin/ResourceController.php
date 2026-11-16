<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\Jadwal;
use App\Models\Rute;
use App\Models\User;
use App\Models\Wilayah;
use App\Services\ActivationService;
use App\Services\AktivitasLogger;
use App\Services\NotifikasiService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

abstract class ResourceController extends Controller
{
    protected string $model;

    protected string $feature;

    public function index(Request $request): View
    {
        $query = ($this->model)::query()->with($this->relations());
        if ($this->feature === 'pengguna') {
            if ($request->filled('q')) {
                $term = '%'.$request->string('q').'%';
                $query->where(fn ($q) => $q->where('nama', 'like', $term)->orWhere('email', 'like', $term)->orWhere('kode', 'like', $term));
            }
            if (in_array($request->status, ['aktif', 'nonaktif'], true)) {
                $query->where('status', $request->status);
            }
            if (in_array($request->role, ['warga', 'petugas', 'admin'])) {
                $query->where('role', $request->role);
            }
        }
        $items = $query->latest()->paginate(15)->withQueryString();

        return view('admin.'.$this->feature.'.index', compact('items'));
    }

    public function create(): View
    {
        return $this->form();
    }

    public function edit(int $id): View
    {
        return $this->form(($this->model)::findOrFail($id));
    }

    private function form(?Model $item = null): View
    {
        return view('admin.'.$this->feature.'.form', [
            'items' => ($this->model)::query()->with($this->relations())->latest()->paginate(15),
            'item' => $item,
            'wilayah' => Wilayah::where('aktif', true)->get(),
            'petugas' => User::with(['wilayah', 'areaTugas'])->where('role', 'petugas')->where('status', 'aktif')->get(),
            'jadwal' => Jadwal::with('wilayah')->whereHas('wilayah', fn ($query) => $query->where('aktif', true))->where('status', 'aktif')->get(),
        ]);
    }

    private function relations(): array
    {
        return match ($this->feature) {
            'pengguna' => ['wilayah', 'areaTugas'],
            'jadwal' => ['wilayah'],
            'rute' => ['wilayah', 'jadwal', 'petugas', 'titik'],
            default => [],
        };
    }

    protected function persist(Request $request, ?int $id = null): RedirectResponse
    {
        $saved = DB::transaction(function () use ($request, $id) {
            $item = $id ? ($this->model)::lockForUpdate()->findOrFail($id) : new ($this->model);
            $data = $request->validated();
            $points = $data['titik'] ?? [];
            $areas = $data['area_ids'] ?? [];
            unset($data['area_ids']);
            unset($data['titik']);
            if ($item instanceof User && $item->exists) {
                abort_if($item->is_super && ($request->user()->id !== $item->id || $data['role'] !== 'admin' || $data['status'] !== 'aktif'), 403, 'Admin utama tidak dapat dinonaktifkan atau diubah rolenya.');
                abort_if($item->id === $request->user()->id && ($data['role'] !== 'admin' || $data['status'] !== 'aktif'), 403);
            }
            if ($item instanceof User && empty($data['password'])) {
                unset($data['password']);
            }
            if ($item instanceof User) {
                $data['name'] = $data['nama'];
                if (! $item->exists) {
                    $data['password'] = Str::random(64);
                    $data['password_setup_required'] = true;
                }
            }
            if ($item instanceof Jadwal) {
                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                $data['hari'] = array_values(array_intersect($days, $data['hari']));
            }
            if ($item instanceof Edukasi && $data['status'] === 'terbit' && ! $item->published_at) {
                $data['published_at'] = now();
            }
            $verified = $item instanceof User && $item->exists && $item->role === 'petugas' && $item->status === 'nonaktif' && $data['status'] === 'aktif';
            if ($item instanceof User && $item->exists && $item->wilayah_id && ! $item->wilayah?->aktif && empty($data['wilayah_id'])) {
                unset($data['wilayah_id']);
            }
            $item->fill($data)->save();
            if ($item instanceof User) {
                $item->areaTugas()->sync($item->role === 'petugas' ? $areas : []);
            }
            if ($verified) {
                app(AktivitasLogger::class)->log('pengguna', 'Petugas baru berhasil diverifikasi', $item->nama);
            }
            if ($item instanceof Rute) {
                $item->titik()->delete();
                foreach ($points as $i => $point) {
                    $item->titik()->create(array_merge($point, ['urutan' => $i + 1]));
                }
                if ($item->petugas) {
                    // Tautan lama disimpan; notifikasi diarahkan ke Beranda selama fitur Petugas lain belum aktif.
                    // app(NotifikasiService::class)->send($item->petugas, 'Rute pengangkutan diperbarui', $item->kode, 'sistem', route('petugas.rute.index'));
                    app(NotifikasiService::class)->send($item->petugas, 'Rute pengangkutan diperbarui', $item->kode, 'sistem', route('petugas.beranda'));
                }
            }
            if ($item instanceof Jadwal) {
                foreach (User::where('role', 'warga')->where('wilayah_id', $item->wilayah_id)->get() as $warga) {
                    app(NotifikasiService::class)->send($warga, 'Jadwal pengangkutan '.$item->wilayah->nama.' diperbarui', 'Periksa jadwal pengangkutan terbaru.', 'jadwal', route('warga.jadwal'));
                }
            }
            app(AktivitasLogger::class)->log($this->feature, ucfirst(str_replace('-', ' ', $this->feature)).' '.($id ? 'diperbarui' : 'ditambahkan'));

            return $item;
        });

        if ($saved instanceof User && $id === null) {
            $sent = app(ActivationService::class)->send($saved);

            return redirect()->route('admin.pengguna.index')->with('sukses', $sent ? 'Pengguna tersimpan. Tautan pengaturan kata sandi dikirim melalui email.' : 'Pengguna tersimpan, tetapi email aktivasi belum terkirim. Konfigurasikan email lalu kirim ulang aktivasi. Akun belum dapat digunakan.');
        }

        return redirect()->route('admin.'.$this->feature.'.index')->with('sukses', 'Perubahan berhasil disimpan.');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        DB::transaction(function () use ($request, $id) {
            $item = ($this->model)::lockForUpdate()->findOrFail($id);
            if ($item instanceof User) {
                abort_if($item->is_super || $item->id === $request->user()->id, 403, 'Akun ini tidak dapat dihapus.');
            }
            $item->delete();
            app(AktivitasLogger::class)->log($this->feature, ucfirst(str_replace('-', ' ', $this->feature)).' dihapus');
        });

        return back()->with('sukses', 'Data berhasil dihapus.');
    }
}
