<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class StudentController extends Controller
{
    public function index()
    {
        return view('admin.student.index', [
            'breadcrumbs' => [
                'title' => 'Data Siswa',
                'path' => [
                    'Master Data' => route('admin.students.index'),
                    'Data Siswa' => 0
                ]
            ]
        ]);
    }

    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('error', 'Invalid');
        }
        $user = User::with('student', 'registration')->find($id);
        return view('admin.student.show', [
            'breadcrumbs' => [
                'title' => 'Detail Data Siswa',
                'path' => [
                    'Master Data' => route('admin.students.index'),
                    'Detail Data Siswa' => 0
                ]
            ],
            'user' => $user
        ]);
    }

    public function verifBerkas($id, $status)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $user = User::findOrFail($decrypted);
            $user->registration->update([
                'status_kelulusan' => $status,
                'catatan_kelulusan' => isset($_GET['catatan_kelulusan']) ? $_GET['catatan_kelulusan'] : '',
            ]);

            return redirect()->route('admin.students.show', Crypt::encrypt($user->id))
                ->with('success', 'Calon siswa berhasil diverifikasi.');
        } catch (DecryptException $th) {
        }
    }
}
