<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        return view('admin.payment.index', [
            'breadcrumbs' => [
                'title' => 'Data Pembayaran',
                'path' => [
                    'Data Pembayaran' => 0
                ]
            ]
        ]);
    }

    public function create()
    {
        return view('admin.payment.create', [
            'breadcrumbs' => [
                'title' => 'Bayar Tagihan',
                'path' => [
                    'Bayar Tagihan' => 0
                ]
            ],
            'users' => User::with(['student', 'payment', 'registration'])->whereHas('payment', function($query){
                $query->where('status', Payment::STATUS_BELUM_LUNAS);
            })->whereHas('registration', function($query){
                $query->where('status_kelulusan', Registration::STATUS_LULUS);
            })->whereRoleIs('siswa')->get(),
            'no_pembayaran' => generateNoPayment()
        ]);
    }

    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
        }
        return view('admin.payment.show', [
            'breadcrumbs' => [
                'title' => 'Detail Pembayaran',
                'path' => [
                    'Detail Pembayaran' => 0
                ]
            ],
            'payment' => Payment::with('itemPayments')->find($id)
        ]);
    }
}
