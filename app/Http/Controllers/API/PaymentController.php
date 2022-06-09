<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm"
        data-id="' . Crypt::encrypt($row->id) . '">Ubah</a> <a href="javascript:void(0)"
        class="delete btn btn-danger btn-sm" id="' . Crypt::encrypt($row->id) . '">Hapus</a>';
                    return $actionBtn;
                })
                ->addColumn('nominal', function ($row) {
                    return numberFormat($row->nominal, 'Rp.');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function updateOrCreate(Request $request)
    {
        try {
            if (isset($request->nominal)) {
                $request->merge(['nominal' => replaceRupiah($request->nominal)]);
            }
            Payment::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'nama' => $request->nama,
                    'nominal' => $request->nominal
                ]
            );
            return response()->json([
                'status' => 'success',
                'message' => isset($request->id) ? 'Ubah Data Tipe Pembayaran' : 'Menambahkan data Tipe Pembayaran',
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ? $code = 400 : $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }

    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $type_payment = Payment::find($id);
            if (!$type_payment) {
                throw new Exception('Data Tipe Pembayaran tidak ditemukan!', 400);
            }
            $data = [
                'id' => $type_payment->id,
                'nama' => $type_payment->nama,
                'nominal' => $type_payment->nominal
            ];
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ? $code = 400 : $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $type_payment = Payment::find($id);

            if (!$type_payment) {
                throw new Exception('Data Tipe Pembayaran tidak ditemukan!', 400);
            }

            $type_payment->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data Tipe Pembayaran',
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
