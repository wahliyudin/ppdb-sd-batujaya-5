<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestFormStore;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function index()
    {
        $user = User::with('student', 'registration')->find(auth()->user()->id);
        return view('student.form', [
            'breadcrumbs' => [
                'title' => 'Form Pendaftaran',
                'path' => [
                    'Form Pendaftaran' => 0
                ]
            ],
            'student' => $user->student,
            'registration' => $user->registration
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
            if (isset($request->id)) {
                $user = User::with('registration')->find($request->user_id);
                if (in_array($user->registration->status_kelulusan, [Registration::STATUS_KEMBALIKAN,
                Registration::STATUS_TOLAK])) {
                    $user->registration()->update(['status_kelulusan' => Registration::STATUS_SUDAH_KIRIM]);
                }
            }
            $message = $request->id ? 'Data berhasil diubah' : 'Data berhasil disimpan';
            return redirect()->route('students.form-pendaftaran')->with('success', $message);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function kirimKePanitia()
    {
        try {
            Registration::create([
                'no_daftar' => generateNoDaftar(),
                'tanggal' => now()->format('Y-m-d'),
                'user_id' => auth()->user()->id,
                'status_kelulusan' => Registration::STATUS_SUDAH_KIRIM
            ]);
            return redirect()->route('students.form-pendaftaran')->with('success', 'Data berhasil dikirim');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
