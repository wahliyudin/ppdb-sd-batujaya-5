<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const STATUS_LUNAS = true;
    const STATUS_BELUM_LUNAS = false;

    protected $fillable = [
        'user_id',
        'tagihan',
        'total_bayar',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemPayments()
    {
        return $this->hasMany(ItemPayment::class);
    }
}
