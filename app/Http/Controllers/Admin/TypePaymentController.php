<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypePaymentController extends Controller
{
    public function index()
    {
        return view('admin.type-payment.index', [
            'breadcrumbs' => [
                'title' => 'Data Tipe Pembayaran',
                'path' => [
                    'Master Data' => route('admin.type-payments.index'),
                    'Data Tipe Pembayaran' => 0
                ]
            ]
        ]);
    }
}
