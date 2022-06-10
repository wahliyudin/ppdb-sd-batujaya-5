@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Siswa</label>
                                <select name="user_id" required id="user_id" class="form-control select2"
                                    style="width: 100%;">
                                    <option selected="selected" disabled>-- pilih --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->student->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tanggal</label>
                                <div class="input-group date" id="tanggal" data-target-input="nearest">
                                    <input type="text" required name="tanggal" class="form-control datetimepicker-input"
                                        data-target="#tanggal" value="{{ now()->format('d/m/Y') }}">
                                    <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>No Pembayaran</label>
                                <input type="text" required readonly name="no_pembayaran" id="no_pembayaran"
                                    value="{{ $no_pembayaran }}" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Tagihan</label>
                                <input type="text" readonly class="form-control" id="tagihan">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Jumlah Bayar</label>
                                <input type="text" required class="form-control" name="nominal" id="nominal">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kembalian</label>
                                <input type="text" name="kembalian" id="kembalian" value="Rp. 0" readonly
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" id="keterangan" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button id="btn-save" class="btn btn-primary float-right">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.inc.select2')
@include('layouts.inc.datetimepicker')
@include('layouts.inc.toastr')
@push('script')
    <script>
        var ajaxError = function(jqXHR, xhr, textStatus, errorThrow, exception) {
            if (jqXHR.status === 0) {
                toastr.error('Not connect.\n Verify Network.', 'Error!');
            } else if (jqXHR.status == 400) {
                toastr.warning(jqXHR['responseJSON'].message, 'Peringatan!');
            } else if (jqXHR.status == 404) {
                toastr.error('Requested page not found. [404]', 'Error!');
            } else if (jqXHR.status == 500) {
                toastr.error('Internal Server Error [500].' + jqXHR['responseJSON'].message, 'Error!');
            } else if (exception === 'parsererror') {
                toastr.error('Requested JSON parse failed.', 'Error!');
            } else if (exception === 'timeout') {
                toastr.error('Time out error.', 'Error!');
            } else if (exception === 'abort') {
                toastr.error('Ajax request aborted.', 'Error!');
            } else {
                toastr.error('Uncaught Error.\n' + jqXHR.responseText, 'Error!');
            }
        };
        $('#nominal').keyup(function(e) {
            $(this).val(formatRupiah(e.target.value, 'Rp.'));
        });
        $('#user_id').select2();
        $('#tanggal').datetimepicker({
            format: 'L'
        });

        $('#user_id').change(function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ url('/') }}/api/students/" + e.target.value + "/payment",
                dataType: 'json',
                success: function(res) {
                    $('#tagihan').val(formatRupiah(String(res.data.payment.tagihan - res.data.payment
                        .total_bayar), 'Rp.'));
                },
                error: ajaxError,
            });
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
        }

        function replaceFormatRupiah(str) {
            return str.replace(new RegExp(escapeRegExp('.'), 'g'), '').replace('Rp ', '');
        }

        $('#nominal').keyup(function(e) {
            e.preventDefault();
            var kembalian = parseInt(replaceFormatRupiah(e.target.value)) - parseInt(replaceFormatRupiah($(
                '#tagihan').val()));
            var a = parseInt(replaceFormatRupiah($('#tagihan').val()));
            var b = parseInt(replaceFormatRupiah(e.target.value));
            var c = parseInt(replaceFormatRupiah($('#kembalian').val()));
            if (a >= b) {
                $('#kembalian').val('Rp. 0');
            } else {
                $('#kembalian').val(formatRupiah(String(kembalian), 'Rp. '));
            }
        });

        $('body').on('click', '#btn-save', function(event) {
            var user_id = $("#user_id").val();
            var no_pembayaran = $("#no_pembayaran").val();
            var tanggal = $('input[name="tanggal"]').val();
            var nominal = replaceFormatRupiah(String($('#nominal').val()));
            var kembalian = replaceFormatRupiah(String($('#kembalian').val()));
            var keterangan = $("#keterangan").val();
            $("#btn-save").html('Please Wait...');
            $("#btn-save").attr("disabled", true);

            // ajax
            $.ajax({
                type: "POST",
                url: "{{ route('api.payments.store') }}",
                data: {
                    user_id: user_id,
                    no_pembayaran: no_pembayaran,
                    tanggal: tanggal,
                    keterangan: keterangan,
                    nominal: nominal,
                    kembalian: kembalian
                },
                dataType: 'json',
                success: function(res) {
                    $("#btn-save").html('Submit');
                    $("#btn-save").attr("disabled", false);
                    toastr.success(res.message, 'Berhasil!');
                    window.location.reload()
                },
                error: ajaxError,
            });
        });
    </script>
@endpush
