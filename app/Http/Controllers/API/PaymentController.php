<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequestStore;
use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::with('user.student')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="'.route('admin.payments.show', Crypt::encrypt($row->id)).'" class="btn btn-success btn-sm">detail</a>';
                    return $actionBtn;
                })
                ->addColumn('tagihan', function ($row) {
                    return numberFormat($row->tagihan, 'Rp.');
                })
                ->addColumn('total_bayar', function ($row) {
                    return numberFormat($row->total_bayar, 'Rp.');
                })
                ->addColumn('status', function ($row) {
                    return $row->tagihan == $row->total_bayar ? 'Lunas' : 'Belum Lunas';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(PaymentRequestStore $request)
    {
        try {
            $payment = Payment::where('user_id', $request->user_id)->first();
            $payment->itemPayments()->create([
                'payment_id' => $payment->id,
                'no_pembayaran' => $request->no_pembayaran,
                'nominal' => $request->nominal,
                'tanggal' => Carbon::make($request->tanggal)->format('Y-m-d'),
                'kembalian' => $request->kembalian,
                'keterangan' => $request->keterangan
            ]);
            $payment->update([
                'status' => $payment->total_bayar + ($request->nominal - $request->kembalian) == $payment->tagihan ?
                Payment::STATUS_LUNAS : Payment::STATUS_BELUM_LUNAS,
                'total_bayar' => $payment->total_bayar + ($request->nominal - $request->kembalian)
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran berhasil',
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
