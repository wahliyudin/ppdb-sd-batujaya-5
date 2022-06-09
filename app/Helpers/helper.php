<?php

use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('numberFormat')) {
    function numberFormat($number, $prefix = null)
    {
        if (isset($prefix)) {
            return $prefix . ' ' . number_format($number, 0, ',', '.');
        }
        return number_format($number, 0, ',', '.');
    }
}

if (!function_exists('replaceRupiah')) {
    function replaceRupiah(string $rupiah)
    {
        $rupiah = Str::replace('Rp. ', '', $rupiah);
        return (int) Str::replace('.', '', $rupiah);
    }
}

if (!function_exists('generateNoDaftar')) {
    function generateNoDaftar()
    {
        $thnBulan = Carbon::now()->year . Carbon::now()->month;
        if (Registration::count() === 0) {
            return $thnBulan . '10000001';
        } else {
            return $thnBulan . (int) substr(Registration::get()->last()->no_daftar, -8) + 1;
        }
    }
}
