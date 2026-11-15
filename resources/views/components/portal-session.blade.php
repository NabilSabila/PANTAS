@auth
    <div class="notice" role="status">
        Anda sedang masuk sebagai <strong>{{ auth()->user()->nama }}</strong>
        ({{ ['warga' => 'Warga', 'petugas' => 'Petugas Kebersihan', 'admin' => 'Admin'][auth()->user()->role] }}).
        Masuk dengan akun portal ini untuk berganti akun.
    </div>
@endauth
