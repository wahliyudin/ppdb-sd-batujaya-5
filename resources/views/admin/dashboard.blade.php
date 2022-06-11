@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row justify-content-center">
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $jumlah_siswa }}</h3>

                        <p>Jumlah Siswa</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('admin.students.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ numberFormat($total_pendapatan, 'Rp.') }}</h3>

                        <p>Total Pendapatan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="{{ route('admin.payments.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endpush
@push('script')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
@endpush
