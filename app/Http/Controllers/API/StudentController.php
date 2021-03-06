<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data =User::with('student')->has('student')->whereRoleIs('siswa')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('admin.students.show', Crypt::encrypt($row->id)) . '"
                        class="btn btn-success btn-sm">Detail</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" id="' . Crypt::encrypt($row->id) . '">Hapus</a>';
                    return $actionBtn;
                })
                ->addColumn('student.jenis_kelamin', function($row){
                    return $row->student->jenis_kelamin == 'L'? 'Laki-laki' :'Perempuan';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $user = User::find($id);

            if (!$user) {
                throw new Exception('Data Siswa tidak ditemukan!', 400);
            }

            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data Siswa',
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ? $code = 400 : $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }

    public function studentPayment($id)
    {
        try {
            $user = User::with('payment')->find($id);
            if (!$user) {
                throw new Exception('Data Siswa tidak ditemukan!', 400);
            }
            return response()->json([
                'status' => 'success',
                'data' => $user,
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ? $code = 400 : $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }
}
