@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="payment" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Pembayaran</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment->itemPayments as $item_payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item_payment->no_pembayaran }}</td>
                                        <td>{{ $item_payment->tanggal }}</td>
                                        <td>{{ numberFormat((int) $item_payment->nominal, 'Rp.') }}</td>
                                        <td>{{ $item_payment->keterangan }}</td>
                                        <td>
                                            <div class="d-flex align-item-center">
                                                <a href="{{ route('admin.payments.bukti-pembayaran', Crypt::encrypt($item_payment->id)) }}"
                                                    target="_blank" class="btn btn-sm btn-success mr-2"><i
                                                        class="fas fa-print mr-1"></i>
                                                    Cetak</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.inc.toastr')
@include('layouts.inc.datatables')
@push('script')
    <script>
        $(function() {
            $("#payment").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#payment_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
