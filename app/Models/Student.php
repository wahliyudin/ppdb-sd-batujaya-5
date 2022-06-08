<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nama',
        'asal_sekolah',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'anak_ke',
        'alamat',
        'no_hp',
        'nama_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'alamat_ortu',
        'nama_wali',
        'pekerjaan_wali',
        'alamat_wali',
        'user_id'
    ];

    public function getJenisKelaminAttribute($value)
    {
        switch ($value) {
            case 'L':
                return 'Laki-laki';
                break;
            case 'P':
                return 'Perempuan';
                break;
        }
    }
}
