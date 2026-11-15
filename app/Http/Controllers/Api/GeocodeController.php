<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GeoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GeocodeController extends Controller
{
    public function search(Request $request, GeoService $geo): JsonResponse
    {
        $input = $request->validate(['q' => 'required|string|min:3|max:200']);
        try {
            return response()->json($geo->geocode('search', $input));
        } catch (\Throwable $e) {
            Log::warning('Pencarian lokasi gagal.', ['provider' => config('maps.provider'), 'exception' => get_class($e), 'status' => $e->getCode()]);

            return response()->json(['message' => match ($e->getCode()) {
                401, 403 => 'Konfigurasi atau izin API geocoding belum valid. Hubungi admin atau pilih titik secara manual.',
                429 => 'Batas pencarian lokasi tercapai. Tunggu sebentar atau pilih titik secara manual.',
                default => 'Pencarian lokasi sedang tidak tersedia. Silakan coba lagi atau tentukan titik secara manual.',
            }], $e->getCode() === 429 ? 429 : 503);
        }
    }

    public function reverse(Request $request, GeoService $geo): JsonResponse
    {
        $input = $request->validate(['lat' => 'required|numeric|between:-90,90', 'lng' => 'required|numeric|between:-180,180']);
        try {
            return response()->json($geo->geocode('reverse', ['lat' => $input['lat'], 'lon' => $input['lng']]));
        } catch (\Throwable $e) {
            Log::warning('Pencarian alamat koordinat gagal.', ['provider' => config('maps.provider'), 'exception' => get_class($e), 'status' => $e->getCode()]);

            return response()->json(['message' => 'Alamat otomatis tidak ditemukan. Silakan lengkapi alamat secara manual.'], 503);
        }
    }
}