<?php

return [
    'provider' => env('MAPS_PROVIDER', 'google'),
    'geoapify_api_key' => env('GEOAPIFY_API_KEY'),
    'geoapify_url' => 'https://api.geoapify.com/v1/geocode',
    'ca_bundle' => env('MAPS_CA_BUNDLE'),
    'google_browser_key' => env('GOOGLE_MAPS_BROWSER_KEY'),
    'google_map_id' => env('GOOGLE_MAPS_MAP_ID', 'DEMO_MAP_ID'),
    'tile_url' => 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    'attribution' => '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors</a>',
    'nominatim_url' => env('NOMINATIM_URL', 'https://nominatim.openstreetmap.org'),
    'contact_email' => env('MAPS_CONTACT_EMAIL', 'admin@example.com'),
    'default_center' => ['lat' => -7.2575, 'lng' => 112.7521],
    'bounds' => ['south' => -7.37, 'west' => 112.57, 'north' => -7.18, 'east' => 112.87],
    'default_zoom' => 13,
    'boundary_path' => public_path('assets/data/surabaya.geojson'),
    'boundary_url' => '/assets/data/surabaya.geojson',
];
