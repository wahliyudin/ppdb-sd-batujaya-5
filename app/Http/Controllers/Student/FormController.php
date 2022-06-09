<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestFormStore;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function index()
    {
        return view('student.form', [
            'breadcrumbs' => [
                'title' => 'Form Pendaftaran',
                'path' => [
                    'Form Pendaftaran' => 0
                ]
            ],
            'student' => User::with('student')->find(auth()->user()->getAuthIdentifier())->student
        ]);
    }

    public function store(RequestFormStore $request)
    {
        try {
            $request->merge(['user_id' => auth()->user()->id]);
            $request->merge(['tanggal_lahir' => Carbon::make($request->tanggal_lahir)->format('Y-m-d')]);
            Student::updateOrCreate(
                [
                    'id' => $request->id
                ],
                $request->all()
            );
            $message = $request->id ? 'Data berhasil diubah' : 'Data berhasil disimpan';
            return redirect()->route('students.form-pendaftaran')->with('success', $message);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
