<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class BantuanController extends Controller
{
    public function index(): View
    {
        return view('petugas.pengaturan.bantuan', ['faq' => json_decode('[{"tanya": "Bagaimana memulai rute hari ini?", "jawab": "Buka Beranda lalu tekan Mulai Rute. Titik pertama otomatis berstatus Proses; tandai selesai satu per satu setelah pekerjaan dilakukan."}, {"tanya": "Bagaimana memperbarui status laporan warga?", "jawab": "Buka menu Laporan, pilih laporan, lalu ubah status dan isi catatan pada kartu Kelola status laporan. Warga dan admin akan langsung melihat perubahannya."}, {"tanya": "Apa yang dimaksud laporan prioritas tinggi?", "jawab": "Laporan B3, sampah menumpuk dan berbau, atau jumlah lebih dari 5 kantong. Tangani lebih dahulu sesuai SOP dan keselamatan kerja."}, {"tanya": "Bagaimana jika lokasi tidak dapat dijangkau?", "jawab": "Catat kondisinya pada Tambah Catatan, hubungi penanggung jawab, dan jangan mengubah urutan rute tanpa arahan."}, {"tanya": "Bagaimana mengubah data profil atau area tugas?", "jawab": "Data pribadi dapat diubah di Edit Profil. Area tugas dan rute hanya dapat diubah oleh admin."}]', true)]);
    }
}
