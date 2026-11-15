<?php

namespace App\Rules;

use App\Services\SurabayaBoundary;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WithinSurabaya implements ValidationRule
{
    public function __construct(private mixed $lng) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_numeric($value) || ! is_numeric($this->lng)) {
            return;
        }if (! app(SurabayaBoundary::class)->contains((float) $value, (float) $this->lng)) {
            $fail('Pilih titik di dalam batas Kota Surabaya. Titik di luar area layanan tidak dapat disimpan.');
        }
    }
}