@if(session('sukses'))<div class="flash" role="status">{{ session('sukses') }}<button type="button" class="outline small" onclick="this.parentElement.remove()">Tutup</button></div>@endif
@if(session('peringatan'))<div class="flash warning" role="alert">{{ session('peringatan') }}</div>@endif
