@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        @if (isset($registration))
            <div class="row mb-4">
                <div class="col-md-12">
                    @if (in_array($registration->status_kelulusan, [\App\Models\Registration::STATUS_KEMBALIKAN]))
                        <div class="card bg-warning">
                            <div class="card-body text-center">
                                <h3>Silahkan Perbaiki Data Anda, Lalu Kirim Kembali</h3>
                            </div>
                        </div>
                    @elseif (in_array($registration->status_kelulusan, [\App\Models\Registration::STATUS_TOLAK]))
                        <div class="card bg-danger">
                            <div class="card-body text-center">
                                <h3>Maaf!, Data Anda Di TOLAK</h3>
                            </div>
                        </div>
                    @elseif (in_array($registration->status_kelulusan, [\App\Models\Registration::STATUS_TIDAK_LULUS]))
                        <div class="card bg-danger">
                            <div class="card-body text-center">
                                <h4>MAAF ANDA TIDAK LULUS</h4>
                            </div>
                        </div>
                    @elseif (in_array($registration->status_kelulusan, [\App\Models\Registration::STATUS_LULUS]))
                        <div class="card bg-green">
                            <div class="card-body text-center">
                                <h4>Selamat!, Anda Dinyatakan LULUS</h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        <div class="row">
            @if (isset($registration))
                <div class="col-md-4">
                    <!-- The time line -->
                    <div class="timeline">
                        <!-- timeline time label -->
                        <div class="time-label">
                            <span
                                class="bg-red">{{ \Carbon\Carbon::make($registration->tanggal)->isoFormat('DD MMMM, Y') }}</span>
                        </div>
                        <!-- /.timeline-label -->
                        <!-- timeline item -->
                        <div>
                            <i class="fas fa-paper-plane bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                <h3 class="timeline-header no-border">
                                    Data Berhasil Dikirim
                                </h3>
                            </div>
                        </div>

                        <!-- END timeline item -->
                        <!-- timeline item -->
                        <div>
                            @if (in_array($registration->status_kelulusan, [\App\Models\Registration::STATUS_VERIFIKASI, \App\Models\Registration::STATUS_LULUS]))
                                <i class="fas fa-user-check bg-yellow"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                    <h3 class="timeline-header no-border">
                                        Data Terverifikasi
                                    </h3>
                                </div>
                            @else
                                @if (in_array($registration->status_kelulusan, [\App\Models\Registration::STATUS_KEMBALIKAN, \App\Models\Registration::STATUS_TOLAK, \App\Models\Registration::STATUS_TIDAK_LULUS]))
                                    <i class="fas fa-times bg-danger"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                        <h3 class="timeline-header no-border">
                                            {{ isset($registration->catatan_kelulusan) ? $registration->catatan_kelulusan : 'Maaf Data Anda Belum Sesuai' }}
                                        </h3>
                                    </div>
                                @else
                                    <i class="fas fa-spinner bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                        <h3 class="timeline-header no-border">
                                            Sedang Diverifikasi Oleh Panitia
                                        </h3>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div>
                            @if (in_array($registration->status_kelulusan, [\App\Models\Registration::STATUS_LULUS]))
                                <i class="fas fa-handshake bg-green"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                    <h3 class="timeline-header no-border">
                                        Selamat!, Anda Diterima
                                    </h3>
                                </div>
                            @else
                                @if (in_array($registration->status_kelulusan, [\App\Models\Registration::STATUS_VERIFIKASI]))
                                    <i class="fas fa-spinner bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                        <h3 class="timeline-header no-border">
                                            Sedang Diseleksi Oleh Panitia
                                        </h3>
                                    </div>
                                @endif
                            @endif
                        </div>
                        @if ($registration->status_kelulusan == \App\Models\Registration::STATUS_LULUS)
                            <div>
                                <i class="fas fa-check bg-gray"></i>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <div
                class="{{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'col-8' : 'col-12' }}">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('students.form-pendaftaran.store') }}" method="POST">
                            @csrf
                            <div class="row justify-content-between align-items-center">
                                <h4>Data Siswa</h4>
                                @if (isset($student) && !$registration)
                                    <a href="{{ route('students.form-pendaftaran.kirim-ke-panitia') }}"
                                        class="btn btn-secondary">Kirim Data Kepanitia</a>
                                @endif
                            </div>
                            <hr>
                            <input type="hidden" name="id" value="{{ isset($student) ? $student->id : '' }}">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="nis">NIS</label>
                                    <input type="number"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="nis" value="{{ old('nis', $student?->nis) }}"
                                        id="nis" placeholder="nis">
                                    @error('nis')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nama">Nama</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="nama" value="{{ old('nama', $student?->nama) }}"
                                        id="nama" placeholder="nama">
                                    @error('nama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="no_hp">No HP</label>
                                    <input type="number"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="no_hp" value="{{ old('no_hp', $student?->no_hp) }}"
                                        id="no_hp" placeholder="no_hp">
                                    @error('no_hp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $student?->tempat_lahir) }}" id="tempat_lahir"
                                        placeholder="tempat_lahir">
                                    @error('tempat_lahir')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Tanggal Lahir</label>
                                    <div class="input-group date" id="tanggal_lahir" data-target-input="nearest">
                                        <input
                                            {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'disabled' : '' }}
                                            type="text" required
                                            value="{{ old('tanggal_lahir', $student?->tanggal_lahir ? \Carbon\Carbon::make($student->tanggal_lahir)->format('d/m/Y') : '') }}"
                                            name="tanggal_lahir" class="form-control datetimepicker-input"
                                            data-target="#tanggal_lahir" value="">
                                        <div class="input-group-append" data-target="#tanggal_lahir"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('tanggal_lahir')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="anak_ke">Anak Ke</label>
                                    <input type="number"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="anak_ke"
                                        value="{{ old('anak_ke', $student?->anak_ke) }}" id="anak_ke"
                                        placeholder="anak_ke">
                                    @error('anak_ke')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'disabled' : '' }}
                                        id="jenis_kelamin" class="form-control select2" style="width: 100%;">
                                        <option selected="selected" disabled>-- pilih --</option>
                                        <option
                                            {{ old('jenis_kelamin', $student?->jenis_kelamin) == 'L' ? 'selected' : '' }}
                                            value="L">Laki-laki</option>
                                        <option
                                            {{ old('jenis_kelamin', $student?->jenis_kelamin) == 'P' ? 'selected' : '' }}
                                            value="P">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="agama">Agama</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="agama" value="{{ old('agama', $student?->agama) }}"
                                        id="agama" placeholder="agama">
                                    @error('agama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="asal_sekolah">Asal Sekolah</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="asal_sekolah"
                                        value="{{ old('asal_sekolah', $student?->asal_sekolah) }}" id="asal_sekolah"
                                        placeholder="asal_sekolah">
                                    @error('asal_sekolah')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="alamat">Alamat</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="alamat"
                                        value="{{ old('alamat', $student?->alamat) }}" id="alamat" placeholder="alamat">
                                    @error('alamat')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <h4>Data Orang Tua</h4>
                            <hr>
                            <h5>Ayah</h5>
                            <hr>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nama_ayah">Nama</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="nama_ayah"
                                        value="{{ old('nama_ayah', $student?->nama_ayah) }}" id="nama_ayah"
                                        placeholder="nama_ayah">
                                    @error('nama_ayah')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pekerjaan_ayah">Pekerjaan</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="pekerjaan_ayah"
                                        value="{{ old('pekerjaan_ayah', $student?->pekerjaan_ayah) }}"
                                        id="pekerjaan_ayah" placeholder="pekerjaan_ayah">
                                    @error('pekerjaan_ayah')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <h5>Ibu</h5>
                            <hr>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nama_ibu">Nama</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="nama_ibu"
                                        value="{{ old('nama_ibu', $student?->nama_ibu) }}" id="nama_ibu"
                                        placeholder="nama_ibu">
                                    @error('nama_ibu')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pekerjaan_ibu">Pekerjaan</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="pekerjaan_ibu"
                                        value="{{ old('pekerjaan_ibu', $student?->pekerjaan_ibu) }}" id="pekerjaan_ibu"
                                        placeholder="pekerjaan_ibu">
                                    @error('pekerjaan_ibu')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="alamat_ortu">Alamat</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="alamat_ortu"
                                        value="{{ old('alamat_ortu', $student?->alamat_ortu) }}" id="alamat_ortu"
                                        placeholder="alamat orang tua">
                                    @error('alamat_ortu')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <h5>Data Wali</h5>
                            <hr>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nama_wali">Nama</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="nama_wali"
                                        value="{{ old('nama_wali', $student?->nama_wali) }}" id="nama_wali"
                                        placeholder="nama_wali">
                                    @error('nama_wali')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pekerjaan_wali">Pekerjaan</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="pekerjaan_wali"
                                        value="{{ old('pekerjaan_wali', $student?->pekerjaan_wali) }}"
                                        id="pekerjaan_wali" placeholder="pekerjaan_wali">
                                    @error('pekerjaan_wali')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="alamat_wali">Alamat</label>
                                    <input type="text"
                                        {{ isset($registration) && in_array($registration->status_kelulusan, [1, 2, 4, 3, 5]) ? 'readonly' : '' }}
                                        class="form-control" name="alamat_wali"
                                        value="{{ old('alamat_wali', $student?->alamat_wali) }}" id="alamat_wali"
                                        placeholder="alamat wali">
                                    @error('alamat_wali')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if (!in_array(isset($registration->status_kelulusan) ? $registration->status_kelulusan : 0, [1, 2, 4, 3, 5]))
                                <div class="row justify-content-end">
                                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.inc.datetimepicker')
@include('layouts.inc.select2')
@include('layouts.inc.toastr')
@push('script')
    <script>
        $('#tanggal_lahir').datetimepicker({
            format: 'L'
        });
        $(function() {
            bsCustomFileInput.init();
            //Initialize Select2 Elements
            $('.select2').select2()
        });
    </script>
@endpush
