<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentRateController extends Controller
{
    public function index()
    {
        return view('admin.payment-rate.index', [
            'breadcrumbs' => [
                'title' => 'Data Tarif Pembayaran',
                'path' => [
                    'Master Data' => route('admin.payment-rates.index'),
                    'Data Tarif Pembayaran' => 0
                ]
            ],
        ]);
    }
}
