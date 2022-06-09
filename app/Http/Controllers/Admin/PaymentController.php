<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('admin.payment.index', [
            'breadcrumbs' => [
                'title' => 'Data Pembayaran',
                'path' => [
                    'Master Data' => route('admin.payments.index'),
                    'Data Pembayaran' => 0
                ]
            ]
        ]);
    }
}
