@props(['lat'=>null,'lng'=>null,'location'=>'lokasi_teks','value'=>null,'height'=>260,'latName'=>'lat','lngName'=>'lng','addressTarget'=>null])
<div class="map-picker" data-map-picker data-centers="{{ json_encode(\App\Models\Wilayah::where('aktif',true)->get()->mapWithKeys(fn($w)=>[$w->id=>['lat'=>$w->lat,'lng'=>$w->lng,'nama'=>$w->nama]])->all()) }}" data-address-target="{{ $addressTarget }}">
    <div class="map-search" data-map-search-wrap>
        <input data-map-search placeholder="Cari alamat atau nama jalan" aria-label="Cari alamat atau nama jalan" autocomplete="off">
        <button class="outline" type="button" data-map-search-button aria-label="Cari lokasi">Cari</button>
    </div>
    <div data-google-search></div>
    <div data-map-results aria-live="polite"></div>
    @if(!$addressTarget)
        <x-field :name="$location" label="Alamat lengkap / detail lokasi" :value="old($location,$value)" data-map-address/>
    @endif
    <small>Untuk pindah lokasi, gunakan pencarian atau peta. Kolom alamat dapat dilengkapi dengan nomor rumah, patokan, dan detail lainnya tanpa memindahkan titik.</small>
    <div data-map-canvas style="height:{{ $height }}px" class="map"></div>
    <div class="form-grid"><x-field :name="$latName" label="Latitude" :value="old($latName,$lat)" readonly data-map-lat/><x-field :name="$lngName" label="Longitude" :value="old($lngName,$lng)" readonly data-map-lng/></div>
    <small data-map-message role="status" aria-live="polite">Tandai lokasi melalui pencarian, klik peta, atau geser marker. Pusat peta bukan lokasi tersimpan.</small>
</div>