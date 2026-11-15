<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class BantuanController extends Controller
{
    public function index(): View
    {
        return view('warga.pengaturan.bantuan', ['faq' => array_slice(json_decode('[{"tanya": "Bagaimana melihat jadwal pengangkutan di wilayah saya?", "jawab": "Buka menu Jadwal pada sidebar. Periksa wilayah, hari, jam, dan jenis sampah yang diangkut. Siapkan sampah terpilah sebelum waktu pengangkutan. Jika ada perubahan, lihat informasi pada halaman jadwal atau notifikasi akun."}, {"tanya": "Bagaimana membuat laporan sampah dengan foto?", "jawab": "Buka menu Laporan Sampah lalu pilih Buat Laporan. Tambahkan foto, isi kategori, kondisi, jumlah, lokasi pada peta, dan deskripsi, kemudian periksa dan kirim laporan."}, {"tanya": "Di mana saya bisa melihat status laporan?", "jawab": "Buka menu Laporan Sampah. Pilih laporanmu untuk melihat perjalanan status dari dikirim hingga selesai, termasuk petugas yang menangani."}, {"tanya": "Kategori sampah apa yang dapat saya laporkan?", "jawab": "Sampah Rumah Tangga, Sampah Elektronik, Minyak Jelantah, B3, dan Sampah Daur Ulang."}, {"tanya": "Apa yang perlu dilakukan jika pengangkutan terlambat?", "jawab": "Periksa banner informasi keterlambatan di Beranda atau notifikasi akunmu. Jika sampah menumpuk lebih dari sehari setelah jadwal, buat laporan baru lengkap dengan foto dan lokasi."}, {"tanya": "Bagaimana memulai rute hari ini?", "jawab": "Buka Beranda lalu tekan Mulai Rute. Titik pertama otomatis berstatus Proses; tandai selesai satu per satu setelah pekerjaan dilakukan."}, {"tanya": "Bagaimana memperbarui status laporan warga?", "jawab": "Buka menu Laporan, pilih laporan, lalu ubah status dan isi catatan pada kartu Kelola status laporan. Warga dan admin akan langsung melihat perubahannya."}, {"tanya": "Apa yang dimaksud laporan prioritas tinggi?", "jawab": "Laporan B3, sampah menumpuk dan berbau, atau jumlah lebih dari 5 kantong. Tangani lebih dahulu sesuai SOP dan keselamatan kerja."}, {"tanya": "Bagaimana jika lokasi tidak dapat dijangkau?", "jawab": "Catat kondisinya pada Tambah Catatan, hubungi penanggung jawab, dan jangan mengubah urutan rute tanpa arahan."}, {"tanya": "Bagaimana mengubah data profil atau area tugas?", "jawab": "Data pribadi dapat diubah di Edit Profil. Area tugas dan rute hanya dapat diubah oleh admin."}]', true), 0, 5)]);
    }
}
