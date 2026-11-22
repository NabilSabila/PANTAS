<?php

namespace App\Http\Requests\Petugas;

use App\Http\Requests\PantasRequest;
use App\Services\SurabayaBoundary;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ProfilRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['nama' => 'required|string|max:120', 'telepon' => 'nullable|string|max:30', 'alamat' => 'nullable|string|max:1000', 'wilayah_id' => ['required', Rule::exists('wilayah', 'id')->where('aktif', true)], 'alamat_lat' => 'nullable|required_with:alamat_lng|numeric|between:-90,90', 'alamat_lng' => 'nullable|required_with:alamat_lat|numeric|between:-180,180', 'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'];
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            if ($validator->errors()->isNotEmpty() || ! $this->filled('alamat_lat')) {
                return;
            }$user = $this->user();
            if ((float) $this->alamat_lat === $user->alamat_lat && (float) $this->alamat_lng === $user->alamat_lng) {
                return;
            }if (! app(SurabayaBoundary::class)->contains((float) $this->alamat_lat, (float) $this->alamat_lng)) {
                $validator->errors()->add('alamat_lat', 'Pilih lokasi alamat di dalam Kota Surabaya.');
            }
        }];
    }
}
