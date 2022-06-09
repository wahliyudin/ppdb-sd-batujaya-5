<div class="col-12">
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('students.form-pendaftaran.store') }}" method="POST">
                @csrf
                <div class="row justify-content-between align-items-center">
                    <h4>Data Siswa</h4>
                    @if (isset($user->student) && !$user->registration)
                        <a href="{{ route('students.form-pendaftaran.kirim-ke-panitia') }}"
                            class="btn btn-secondary">Kirim Data Kepanitia</a>
                    @endif
                </div>
                <hr>
                <input type="hidden" name="id" value="{{ isset($user->student) ? $user->student->id : '' }}">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="nis">NIS</label>
                        <input type="number" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="nis" value="{{ old('nis', $user->student?->nis) }}" id="nis" placeholder="nis">
                        @error('nis')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nama">Nama</label>
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="nama" value="{{ old('nama', $user->student?->nama) }}" id="nama" placeholder="nama">
                        @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="no_hp">No HP</label>
                        <input type="number" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="no_hp" value="{{ old('no_hp', $user->student?->no_hp) }}" id="no_hp"
                            placeholder="no_hp">
                        @error('no_hp')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="tempat_lahir" value="{{ old('tempat_lahir', $user->student?->tempat_lahir) }}"
                            id="tempat_lahir" placeholder="tempat_lahir">
                        @error('tempat_lahir')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tanggal Lahir</label>
                        <div class="input-group date" id="tanggal_lahir" data-target-input="nearest">
                            <input {{ isset($user->registration) ? 'disabled' : '' }} type="text" required
                                value="{{ old('tanggal_lahir', $user->student?->tanggal_lahir ? \Carbon\Carbon::make($user->student->tanggal_lahir)->format('d/m/Y') : '') }}"
                                name="tanggal_lahir" class="form-control datetimepicker-input"
                                data-target="#tanggal_lahir" value="">
                            <div class="input-group-append" data-target="#tanggal_lahir" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        @error('tanggal_lahir')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="anak_ke">Anak Ke</label>
                        <input type="number" {{ isset($user->registration) ? 'readonly' : '' }}
                            class="form-control" name="anak_ke"
                            value="{{ old('anak_ke', $user->student?->anak_ke) }}" id="anak_ke"
                            placeholder="anak_ke">
                        @error('anak_ke')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" {{ isset($user->registration) ? 'disabled' : '' }}
                            id="jenis_kelamin" class="form-control select2" style="width: 100%;">
                            <option selected="selected" disabled>-- pilih --</option>
                            <option
                                {{ old('jenis_kelamin', $user->student?->jenis_kelamin) == 'L' ? 'selected' : '' }}
                                value="L">Laki-laki</option>
                            <option
                                {{ old('jenis_kelamin', $user->student?->jenis_kelamin) == 'P' ? 'selected' : '' }}
                                value="P">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="agama">Agama</label>
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="agama" value="{{ old('agama', $user->student?->agama) }}" id="agama"
                            placeholder="agama">
                        @error('agama')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="asal_sekolah">Asal Sekolah</label>
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="asal_sekolah" value="{{ old('asal_sekolah', $user->student?->asal_sekolah) }}"
                            id="asal_sekolah" placeholder="asal_sekolah">
                        @error('asal_sekolah')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="alamat">Alamat</label>
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="alamat" value="{{ old('alamat', $user->student?->alamat) }}" id="alamat"
                            placeholder="alamat">
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
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="nama_ayah" value="{{ old('nama_ayah', $user->student?->nama_ayah) }}"
                            id="nama_ayah" placeholder="nama_ayah">
                        @error('nama_ayah')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pekerjaan_ayah">Pekerjaan</label>
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="pekerjaan_ayah"
                            value="{{ old('pekerjaan_ayah', $user->student?->pekerjaan_ayah) }}" id="pekerjaan_ayah"
                            placeholder="pekerjaan_ayah">
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
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="nama_ibu" value="{{ old('nama_ibu', $user->student?->nama_ibu) }}" id="nama_ibu"
                            placeholder="nama_ibu">
                        @error('nama_ibu')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pekerjaan_ibu">Pekerjaan</label>
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $user->student?->pekerjaan_ibu) }}"
                            id="pekerjaan_ibu" placeholder="pekerjaan_ibu">
                        @error('pekerjaan_ibu')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="alamat_ortu">Alamat</label>
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="alamat_ortu" value="{{ old('alamat_ortu', $user->student?->alamat_ortu) }}"
                            id="alamat_ortu" placeholder="alamat orang tua">
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
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="nama_wali" value="{{ old('nama_wali', $user->student?->nama_wali) }}"
                            id="nama_wali" placeholder="nama_wali">
                        @error('nama_wali')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pekerjaan_wali">Pekerjaan</label>
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="pekerjaan_wali"
                            value="{{ old('pekerjaan_wali', $user->student?->pekerjaan_wali) }}" id="pekerjaan_wali"
                            placeholder="pekerjaan_wali">
                        @error('pekerjaan_wali')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="alamat_wali">Alamat</label>
                        <input type="text" {{ isset($user->registration) ? 'readonly' : '' }} class="form-control"
                            name="alamat_wali" value="{{ old('alamat_wali', $user->student?->alamat_wali) }}"
                            id="alamat_wali" placeholder="alamat wali">
                        @error('alamat_wali')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @if (!isset($user->registration))
                    <div class="row justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
