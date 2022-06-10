<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('student.profile.index', [
            'breadcrumbs' => [
                'title' => 'Profile',
                'path' => [
                    'Profile' => 0
                ]
            ],
        ]);
    }
}
