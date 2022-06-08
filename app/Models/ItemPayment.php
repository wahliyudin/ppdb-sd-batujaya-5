<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'no_pembayaran',
        'nominal',
        'keterangan'
    ];
}
