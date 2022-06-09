<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    const STATUS_KEMBALIKAN = -1;
    const STATUS_BELUM_DIKIRIM = 0;
    const STATUS_SUDAH_KIRIM = 1;
    const STATUS_VERIFIKASI = 2;
    const STATUS_TOLAK = 3;
    const STATUS_LULUS = 4;
    const STATUS_TIDAK_LULUS = 5;

    protected $fillable = [
        'no_daftar',
        'tanggal',
        'user_id',
        'status_kelulusan',
        'catatan_kelulusan'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // public function getStatusKelulusanAttribute($value)
    // {
    //     switch ($value) {
    //         case -1:
    //             return "Dikembalikan";
    //             break;
    //         case 2:
    //             return "Dikembalikan";
    //             break;
    //     }
    // }
}
