<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentRate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class PaymentRateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PaymentRate::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm"
        data-id="' . Crypt::encrypt($row->id) . '">Ubah</a>';
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
            PaymentRate::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'nominal' => $request->nominal
                ]
            );
            return response()->json([
                'status' => 'success',
                'message' => isset($request->id) ? 'Ubah Data Tarif Pembayaran' : 'Menambahkan data Tarif Pembayaran',
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
            $payment_rate = PaymentRate::find($id);
            if (!$payment_rate) {
                throw new Exception('Data Tarif Pembayaran tidak ditemukan!', 400);
            }
            $data = [
                'id' => $payment_rate->id,
                'nominal' => $payment_rate->nominal
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
            $payment_rate = PaymentRate::find($id);

            if (!$payment_rate) {
                throw new Exception('Data Tarif Pembayaran tidak ditemukan!', 400);
            }

            $payment_rate->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data Tarif Pembayaran',
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
