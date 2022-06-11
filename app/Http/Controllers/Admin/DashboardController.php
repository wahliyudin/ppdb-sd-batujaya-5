<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'breadcrumbs' => [
                'title' => 'Dashboard',
                'path' => [
                    'Dashboard' => 0
                ]
            ],
            'jumlah_siswa' => User::whereRoleIs('siswa')->count(),
            'total_pendapatan' => Payment::sum('total_bayar')
        ]);
    }
}
