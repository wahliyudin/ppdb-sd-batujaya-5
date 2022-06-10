@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ $user->student->nama }}</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.students.index') }}"> Back</a>
                            @if ($user->registration?->status_kelulusan == \App\Models\Registration::STATUS_VERIFIKASI)
                                <a class="btn btn-success btn-sm"
                                    href="{{ route('admin.students.verif-berkas', [Crypt::encrypt($user->id), \App\Models\Registration::STATUS_LULUS]) }}"
                                    onclick="if(confirm('Apakah anda yakin akan meluluskan pendaftar ini ?')){return true}else{return false}">
                                    Lulus</a>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTidakLulus">
                                    Tidak Lulus</button>
                                <div id="modalTidakLulus" class="modal fade" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title mt-0">Tidak Lulus</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('admin.students.verif-berkas', [Crypt::encrypt($user->id), \App\Models\Registration::STATUS_TIDAK_LULUS]) }}"
                                                    id="formtidaklulus">
                                                    <label for="">Catatan</label>
                                                    <textarea name="catatan_kelulusan" class="form-control" cols="30" rows="10"></textarea>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary waves-effect"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                                    onclick="formtidaklulus.submit()">Submit</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            @endif
                            @if ($user->registration?->status_kelulusan == \App\Models\Registration::STATUS_SUDAH_KIRIM)
                                <a class="btn btn-success btn-sm"
                                    href="{{ route('admin.students.verif-berkas', [Crypt::encrypt($user->id), \App\Models\Registration::STATUS_VERIFIKASI]) }}"
                                    onclick="if(confirm('Apakah anda yakin akan memverifikasi berkas pendaftar ini ?')){return true}else{return false}">
                                    Verifikasi Berkas</a>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal">
                                    Kembalikan Berkas</button>
                                <!-- sample modal content -->
                                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title mt-0">Kembalikan Berkas</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('admin.students.verif-berkas', [Crypt::encrypt($user->id), \App\Models\Registration::STATUS_KEMBALIKAN]) }}"
                                                    id="formkembali">
                                                    <label for="">Catatan Pengembalian</label>
                                                    <textarea name="catatan_kelulusan" class="form-control" cols="30" rows="10"></textarea>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary waves-effect"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                                    onclick="formkembali.submit()">Kembalikan Berkas</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTolak"> Tolak
                                    Berkas</button>
                                <!-- sample modal content -->
                                <div id="modalTolak" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title mt-0">Tolak Berkas</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('admin.students.verif-berkas', [Crypt::encrypt($user->id), \App\Models\Registration::STATUS_TOLAK]) }}"
                                                    id="formtolak">
                                                    <label for="">Catatan Penolakan</label>
                                                    <textarea name="catatan_kelulusan" class="form-control" cols="30" rows="10"></textarea>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary waves-effect"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                                    onclick="formtolak.submit()">Tolak Berkas</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>Nama</b></td>
                                <td>{{ $user->student->nama ?? $user->name }}</td>
                            </tr>
                            <tr>
                                <td><b>E-Mail</b></td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if ($user->registration?->status_kelulusan >= \App\Models\Registration::STATUS_SUDAH_KIRIM)
                    @include('admin.student.ringkasan')
                @endif
            </div>
        </div>
    </div>
@endsection
