@extends('template.karyawan.layout')

@php
function formatDate($date) {
    if (!$date) return '-';
    try {
        return \Carbon\Carbon::parse($date)->format('d/m/Y');
    } catch (\Exception $e) {
        return $date;
    }
}

function getFileUrl($filename, $folder = 'dokumen') {
    if (!$filename) return null;
    return asset('storage/' . $folder . '/' . $filename);
}

// Check if karyawan is driver or satpam based on kode_tad
// 03 = Satpam, 06 = Driver
$kodetad = optional($karyawan->tad)->kode_tad ?? '';
$isDriver = (strpos($kodetad, '06') !== false);
$isSatpam = (strpos($kodetad, '03') !== false);
$showDriverSatpam = $isDriver || $isSatpam;
@endphp

@section('content')

<section class="content">
    <div class="container-fluid">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('karyawan.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-edit mr-1"></i> Edit Profil Karyawan
                            </h3>
                            <!--
                            <div class="card-tools">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                </button>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if($karyawan->foto_3x4)
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ getFileUrl($karyawan->foto_3x4, 'foto') }}"
                                    alt="User profile picture">
                                @else
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}"
                                    alt="User profile picture">
                                @endif
                            </div>
                            <h3 class="profile-username text-center">
                                {{ $karyawan->nama_lengkap ?? auth()->user()->name }}
                            </h3>
                            <!--
                            <p class="text-muted text-center">
                                {{ $karyawan->jabatan->nama_jabatan ?? 'Belum ada jabatan' }}
                            </p>
-->
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>NIP</b> <a class="float-right">{{ $karyawan->nip ?? '-' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Status</b> 
                                    <a class="float-right">
                                        @if($karyawan->is_complete)
                                            <span class="badge badge-success">Lengkap</span>
                                        @else
                                            <span class="badge badge-warning">Belum Lengkap</span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#data-kerja" data-toggle="tab">Data Kerja</a></li>
                                <li class="nav-item"><a class="nav-link" href="#data-pribadi" data-toggle="tab">Data Pribadi</a></li>
                                <li class="nav-item"><a class="nav-link" href="#data-fisik" data-toggle="tab">Data Fisik</a></li>
                                <li class="nav-item"><a class="nav-link" href="#kontak" data-toggle="tab">Kontak</a></li>
                                <li class="nav-item"><a class="nav-link" href="#pendidikan" data-toggle="tab">Pendidikan</a></li>
                                <li class="nav-item"><a class="nav-link" href="#identitas" data-toggle="tab">Identitas</a></li>
                                <li class="nav-item"><a class="nav-link" href="#bank-bpjs" data-toggle="tab">Bank & BPJS</a></li>
                                <li class="nav-item"><a class="nav-link" href="#dokumen" data-toggle="tab">Dokumen</a></li>
                                <li class="nav-item"><a class="nav-link" href="#pengalaman" data-toggle="tab">Pengalaman</a></li>
                                <li class="nav-item"><a class="nav-link" href="#kesehatan" data-toggle="tab">Kesehatan</a></li>
                                @if($showDriverSatpam)
                                <li class="nav-item"><a class="nav-link" href="#driver-satpam" data-toggle="tab">
                                    @if($isDriver && $isSatpam)Driver/Satpam
                                    @elseif($isDriver)Driver (SIM A)
                                    @elseif($isSatpam)Satpam (KTA)
                                    @endif
                                </a></li>
                                @endif
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <!-- TAB DATA KERJA -->
                                <div class="active tab-pane" id="data-kerja">
                                    <div class="form-group">
                                        <label>NIP</label>
                                        <input type="text" name="nip" class="form-control" value="{{ old('nip', optional($karyawan)->nip) }}" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Unit PLN</label>
                                                <select name="unitpln_id" class="form-control" required>
                                                    <option value=""> Pilih Unit PLN </option>
                                                    @foreach($unitpln as $unit)
                                                        <option value="{{ $unit->unitpln_id }}" {{ old('unitpln_id', optional($karyawan)->unitpln_id) == $unit->unitpln_id ? 'selected' : '' }}>
                                                            {{ $unit->nama_unit }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jabatan</label>
                                                <select name="jabatan_id" class="form-control" required>
                                                    <option value=""> Pilih Jabatan </option>
                                                    @foreach($jabatan as $j)
                                                        <option value="{{ $j->jabatan_id }}" {{ old('jabatan_id', optional($karyawan)->jabatan_id) == $j->jabatan_id ? 'selected' : '' }}>
                                                            {{ $j->nama_jabatan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Sub Unit</label>
                                                <select name="sub_id" class="form-control" required>
                                                    <option value=""> Pilih Sub Unit </option>
                                                    @foreach($subunit as $sub)
                                                        <option value="{{ $sub->sub_id }}" {{ old('sub_id', optional($karyawan)->sub_id) == $sub->sub_id ? 'selected' : '' }}>
                                                            {{ $sub->nama_sub_unit }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>TAD</label>
                                                <select name="tad_id" class="form-control" required>
                                                    <option value=""> Pilih TAD </option>
                                                    @foreach($tad as $t)
                                                        <option value="{{ $t->tad_id }}" {{ old('tad_id', optional($karyawan)->tad_id) == $t->tad_id ? 'selected' : '' }}>
                                                            {{ $t->nama_tad }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Proyek</label>
                                                <select name="project_id" class="form-control" required>
                                                    <option value="">Pilih Proyek </option>
                                                    @foreach($project as $p)
                                                        <option value="{{ $p->project_id }}" {{ old('project_id', optional($karyawan)->project_id) == $p->project_id ? 'selected' : '' }}>
                                                            {{ $p->nama_project }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                           <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status Karyawan</label>
                                                <select name="status_karyawan" class="form-control">
                                                    <option value="aktif" {{ old('status_karyawan', optional($karyawan)->status_karyawan) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="nonaktif" {{ old('status_karyawan', optional($karyawan)->status_karyawan) == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                                                </select>
                                            </div>
                                        </div>

                                     
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Mulai Aktif</label>
                                                <input type="date" name="tanggal_mulai_aktif" class="form-control" value="{{ old('tanggal_mulai_aktif', optional($karyawan)->tanggal_mulai_aktif) }}">
                                                @if($karyawan->tanggal_mulai_aktif)
                                                <small class="text-muted">Terakhir: {{ formatDate($karyawan->tanggal_mulai_aktif) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Unit Penempatan</label>
                                                <input type="text" name="unit_penempatan" class="form-control" value="{{ old('unit_penempatan', optional($karyawan)->unit_penempatan) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                     
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', optional($karyawan)->keterangan) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB DATA PRIBADI -->
                                <div class="tab-pane" id="data-pribadi">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', optional($karyawan)->nama_lengkap) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Panggilan</label>
                                                <input type="text" name="nama_panggilan" class="form-control" value="{{ old('nama_panggilan', optional($karyawan)->nama_panggilan) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tempat Lahir</label>
                                                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', optional($karyawan)->tempat_lahir) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', optional($karyawan)->tanggal_lahir) }}">
                                                @if($karyawan->tanggal_lahir)
                                                <small class="text-muted">Terakhir: {{ formatDate($karyawan->tanggal_lahir) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control">
                                                    <option value=""> Pilih </option>
                                                    <option value="laki-laki" {{ old('jenis_kelamin', optional($karyawan)->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                    <option value="perempuan" {{ old('jenis_kelamin', optional($karyawan)->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Agama</label>
                                                <input type="text" name="agama" class="form-control" value="{{ old('agama', optional($karyawan)->agama) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Suku Bangsa</label>
                                                <input type="text" name="suku_bangsa" class="form-control" value="{{ old('suku_bangsa', optional($karyawan)->suku_bangsa) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status Nikah</label>
                                                <select name="status_nikah" class="form-control">
                                                    <option value=""> Pilih </option>
                                                    <option value="belum_menikah" {{ old('status_nikah', optional($karyawan)->status_nikah) == 'belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                                    <option value="sudah_nikah" {{ old('status_nikah', optional($karyawan)->status_nikah) == 'sudah_nikah' ? 'selected' : '' }}>Sudah Menikah</option>
                                                    <option value="cerai" {{ old('status_nikah', optional($karyawan)->status_nikah) == 'cerai' ? 'selected' : '' }}>Cerai</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Jumlah Anak</label>
                                        <input type="number" name="jumlah_anak" class="form-control" value="{{ old('jumlah_anak', optional($karyawan)->jumlah_anak) }}" min="0">
                                    </div>

                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', optional($karyawan)->alamat) }}</textarea>
                                    </div>
                                </div>

                                <!-- TAB DATA FISIK -->
                                <div class="tab-pane" id="data-fisik">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tinggi Badan (cm)</label>
                                                <input type="number" name="tinggi_badan" class="form-control" value="{{ old('tinggi_badan', optional($karyawan)->tinggi_badan) }}" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Berat Badan (kg)</label>
                                                <input type="number" name="berat_badan" class="form-control" value="{{ old('berat_badan', optional($karyawan)->berat_badan) }}" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Gol. Darah</label>
                                                <select name="gol_darah" class="form-control">
                                                    <option value=""> Pilih </option>
                                                    <option value="A" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'A' ? 'selected' : '' }}>A</option>
                                                    <option value="B" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'B' ? 'selected' : '' }}>B</option>
                                                    <option value="AB" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                                    <option value="O" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'O' ? 'selected' : '' }}>O</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ukuran Baju</label>
                                                <input type="text" name="ukuran_baju" class="form-control" value="{{ old('ukuran_baju', optional($karyawan)->ukuran_baju) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ukuran Celana</label>
                                                <input type="text" name="ukuran_celana" class="form-control" value="{{ old('ukuran_celana', optional($karyawan)->ukuran_celana) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ukuran Sepatu</label>
                                                <input type="number" name="ukuran_sepatu" class="form-control" value="{{ old('ukuran_sepatu', optional($karyawan)->ukuran_sepatu) }}" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB KONTAK -->
                                <div class="tab-pane" id="kontak">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No HP Utama</label>
                                                <input type="text" name="no_HP_utama" class="form-control" value="{{ old('no_HP_utama', optional($karyawan)->no_HP_utama) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No HP Cadangan</label>
                                                <input type="text" name="no_HP_cadangan" class="form-control" value="{{ old('no_HP_cadangan', optional($karyawan)->no_HP_cadangan) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email Pribadi</label>
                                                <input type="email" name="email_pribadi" class="form-control" value="{{ old('email_pribadi', optional($karyawan)->email_pribadi) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Instagram</label>
                                                <input type="text" name="instagram" class="form-control" value="{{ old('instagram', optional($karyawan)->instagram) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Facebook</label>
                                        <input type="text" name="facebook" class="form-control" value="{{ old('facebook', optional($karyawan)->facebook) }}">
                                    </div>

                                    <hr>
                                    <h5 class="text-primary">Kontak Darurat</h5>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nama Kontak Darurat</label>
                                                <input type="text" name="nama_kontak_darurat" class="form-control" value="{{ old('nama_kontak_darurat', optional($karyawan)->nama_kontak_darurat) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nomor Darurat</label>
                                                <input type="text" name="nomor_darurat" class="form-control" value="{{ old('nomor_darurat', optional($karyawan)->nomor_darurat) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email Darurat</label>
                                                <input type="email" name="email_darurat" class="form-control" value="{{ old('email_darurat', optional($karyawan)->email_darurat) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB PENDIDIKAN -->
                                <div class="tab-pane" id="pendidikan">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Pendidikan Terakhir</label>
                                                <select name="pendidikan_id" class="form-control">
                                                    <option value=""> Pilih Pendidikan </option>
                                                    @foreach($pendidikan as $pen)
                                                        <option value="{{ $pen->pendidikan_id }}" {{ old('pendidikan_id', optional($karyawan)->pendidikan_id) == $pen->pendidikan_id ? 'selected' : '' }}>
                                                            {{ $pen->nama_pendidikan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Universitas/Sekolah</label>
                                                <input type="text" name="nama_perguruan" class="form-control" value="{{ old('nama_perguruan', optional($karyawan)->nama_perguruan) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>File Ijazah</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file_ijazah" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                <label class="custom-file-label">Pilih file baru (opsional)</label>
                                            </div>
                                        </div>
                                        @if($karyawan->file_ijazah)
                                        <div class="mt-2">
                                            <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan: {{ $karyawan->file_ijazah }}</small>
                                            <br>
                                            <a href="{{ getFileUrl($karyawan->file_ijazah, 'ijazah') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                <i class="fas fa-eye"></i> Lihat File
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- TAB IDENTITAS -->
                                <div class="tab-pane" id="identitas">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No KTP</label>
                                                <input type="text" name="no_ktp" class="form-control" value="{{ old('no_ktp', optional($karyawan)->no_ktp) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File KTP</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file_ktp" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                        <label class="custom-file-label">Pilih file baru (opsional)</label>
                                                    </div>
                                                </div>
                                                @if($karyawan->file_ktp)
                                                <div class="mt-2">
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                                    <br>
                                                    <a href="{{ getFileUrl($karyawan->file_ktp, 'ktp') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-eye"></i> Lihat KTP
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No KK</label>
                                                <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk', optional($karyawan)->no_kk) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File KK</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file_kk" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                        <label class="custom-file-label">Pilih file baru (opsional)</label>
                                                    </div>
                                                </div>
                                                @if($karyawan->file_kk)
                                                <div class="mt-2">
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                                    <br>
                                                    <a href="{{ getFileUrl($karyawan->file_kk, 'kk') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-eye"></i> Lihat KK
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No NPWP</label>
                                                <input type="text" name="no_npwp" class="form-control" value="{{ old('no_npwp', optional($karyawan)->no_npwp) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File NPWP</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file_npwp" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                        <label class="custom-file-label">Pilih file baru (opsional)</label>
                                                    </div>
                                                </div>
                                                @if($karyawan->file_npwp)
                                                <div class="mt-2">
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                                    <br>
                                                    <a href="{{ getFileUrl($karyawan->file_npwp, 'npwp') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-eye"></i> Lihat NPWP
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB BANK & BPJS -->
                                <div class="tab-pane" id="bank-bpjs">
                                    <h5 class="text-primary">Bank</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Bank</label>
                                                <input type="text" name="nama_bank" class="form-control" value="{{ old('nama_bank', optional($karyawan)->nama_bank) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No Rekening Bank</label>
                                                <input type="text" name="no_rg_bank" class="form-control" value="{{ old('no_rg_bank', optional($karyawan)->no_rg_bank) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>File Buku Tabungan</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file_buku_tabungan" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                <label class="custom-file-label">Pilih file baru (opsional)</label>
                                            </div>
                                        </div>
                                        @if($karyawan->file_buku_tabungan)
                                        <div class="mt-2">
                                            <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                            <br>
                                            <a href="{{ getFileUrl($karyawan->file_buku_tabungan, 'bank') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                <i class="fas fa-eye"></i> Lihat Buku Tabungan
                                            </a>
                                        </div>
                                        @endif
                                    </div>

                                    <h5 class="text-primary mt-3">BPJS Kesehatan</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No BPJS Kesehatan</label>
                                                <input type="text" name="no_bpjs" class="form-control" value="{{ old('no_bpjs', optional($karyawan)->no_bpjs) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File BPJS Kesehatan</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file_bpjs" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                        <label class="custom-file-label">Pilih file baru (opsional)</label>
                                                    </div>
                                                </div>
                                                @if($karyawan->file_bpjs)
                                                <div class="mt-2">
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                                    <br>
                                                    <a href="{{ getFileUrl($karyawan->file_bpjs, 'bpjs') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-eye"></i> Lihat BPJS Kesehatan
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="text-primary mt-3">BPJS Ketenagakerjaan</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No BPJS Ketenagakerjaan</label>
                                                <input type="text" name="no_bpjstk" class="form-control" value="{{ old('no_bpjstk', optional($karyawan)->no_bpjstk) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File BPJS Ketenagakerjaan</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file_bpjstk" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                        <label class="custom-file-label">Pilih file baru (opsional)</label>
                                                    </div>
                                                </div>
                                                @if($karyawan->file_bpjstk)
                                                <div class="mt-2">
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                                    <br>
                                                    <a href="{{ getFileUrl($karyawan->file_bpjstk, 'bpjstk') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-eye"></i> Lihat BPJS TK
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="text-primary mt-3">BPLK</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No Rekening BPLK</label>
                                                <input type="text" name="no_rek_bplk" class="form-control" value="{{ old('no_rek_bplk', optional($karyawan)->no_rek_bplk) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File Buku BPLK</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file_buku_bplk" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                        <label class="custom-file-label">Pilih file baru (opsional)</label>
                                                    </div>
                                                </div>
                                                @if($karyawan->file_buku_bplk)
                                                <div class="mt-2">
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                                    <br>
                                                    <a href="{{ getFileUrl($karyawan->file_buku_bplk, 'bplk') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-eye"></i> Lihat BPLK
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB DOKUMEN -->
                                <div class="tab-pane" id="dokumen">
                                    <div class="form-group">
                                        <label>File Surat Lamaran</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file_surat_lamaran" class="custom-file-input" accept=".pdf">
                                                <label class="custom-file-label">Pilih file baru (opsional)</label>
                                            </div>
                                        </div>
                                        @if($karyawan->file_surat_lamaran)
                                        <div class="mt-2">
                                            <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan: {{ $karyawan->file_surat_lamaran }}</small>
                                            <br>
                                            <a href="{{ getFileUrl($karyawan->file_surat_lamaran, 'dokumen') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                <i class="fas fa-eye"></i> Lihat Surat Lamaran
                                            </a>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>File CV</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file_cv" class="custom-file-input" accept=".pdf">
                                                <label class="custom-file-label">Pilih file baru (opsional)</label>
                                            </div>
                                        </div>
                                        @if($karyawan->file_cv)
                                        <div class="mt-2">
                                            <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan: {{ $karyawan->file_cv }}</small>
                                            <br>
                                            <a href="{{ getFileUrl($karyawan->file_cv, 'dokumen') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                <i class="fas fa-eye"></i> Lihat CV
                                            </a>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>File Pakta Integritas</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file_pakta_integritas" class="custom-file-input" accept=".pdf">
                                                <label class="custom-file-label">Pilih file baru (opsional)</label>
                                            </div>
                                        </div>
                                        @if($karyawan->file_pakta_integritas)
                                        <div class="mt-2">
                                            <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan: {{ $karyawan->file_pakta_integritas }}</small>
                                            <br>
                                            <a href="{{ getFileUrl($karyawan->file_pakta_integritas, 'dokumen') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                <i class="fas fa-eye"></i> Lihat Pakta Integritas
                                            </a>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>File Data Consist</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file_data_consist" class="custom-file-input" accept=".pdf">
                                                <label class="custom-file-label">Pilih file baru (opsional)</label>
                                            </div>
                                        </div>
                                        @if($karyawan->file_data_consist)
                                        <div class="mt-2">
                                            <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan: {{ $karyawan->file_data_consist }}</small>
                                            <br>
                                            <a href="{{ getFileUrl($karyawan->file_data_consist, 'dokumen') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                <i class="fas fa-eye"></i> Lihat Data Consist
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- TAB PENGALAMAN KERJA -->
                                <div class="tab-pane" id="pengalaman">
                                    <div class="form-group">
                                        <label>Pengalaman Kerja 1</label>
                                        <textarea name="pengalaman_kerja_1" class="form-control" rows="3">{{ old('pengalaman_kerja_1', optional($karyawan)->pengalaman_kerja_1) }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Pengalaman Kerja 2</label>
                                        <textarea name="pengalaman_kerja_2" class="form-control" rows="3">{{ old('pengalaman_kerja_2', optional($karyawan)->pengalaman_kerja_2) }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Pengalaman Kerja 3</label>
                                        <textarea name="pengalaman_kerja_3" class="form-control" rows="3">{{ old('pengalaman_kerja_3', optional($karyawan)->pengalaman_kerja_3) }}</textarea>
                                    </div>
                                </div>

                                <!-- TAB KESEHATAN -->
                                <div class="tab-pane" id="kesehatan">
                                    <h5 class="text-primary">MCU (Medical Check Up)</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal MCU</label>
                                                <input type="date" name="tanggal_mcu" class="form-control" value="{{ old('tanggal_mcu', optional($karyawan)->tanggal_mcu) }}">
                                                @if($karyawan->tanggal_mcu)
                                                <small class="text-muted">Terakhir: {{ formatDate($karyawan->tanggal_mcu) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File Hasil MCU</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file_hasil_mcu" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                        <label class="custom-file-label">Pilih file baru (opsional)</label>
                                                    </div>
                                                </div>
                                                @if($karyawan->file_hasil_mcu)
                                                <div class="mt-2">
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                                    <br>
                                                    <a href="{{ getFileUrl($karyawan->file_hasil_mcu, 'mcu') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-eye"></i> Lihat Hasil MCU
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Perokok</label>
                                                <select name="perokok" class="form-control">
                                                    <option value=""> Pilih </option>
                                                    <option value="1" {{ old('perokok', optional($karyawan)->perokok) == '1' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('perokok', optional($karyawan)->perokok == '0') ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Penyakit Bawaan</label>
                                                <textarea name="penyakit_bawaan" class="form-control" rows="2">{{ old('penyakit_bawaan', optional($karyawan)->penyakit_bawaan) }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="text-primary mt-3">SKCK</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal SKCK</label>
                                                <input type="date" name="tanggal_skck" class="form-control" value="{{ old('tanggal_skck', optional($karyawan)->tanggal_skck) }}">
                                                @if($karyawan->tanggal_skck)
                                                <small class="text-muted">Terakhir: {{ formatDate($karyawan->tanggal_skck) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File SKCK</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file_skck" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                        <label class="custom-file-label">Pilih file baru (opsional)</label>
                                                    </div>
                                                </div>
                                                @if($karyawan->file_skck)
                                                <div class="mt-2">
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                                    <br>
                                                    <a href="{{ getFileUrl($karyawan->file_skck, 'skck') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-eye"></i> Lihat SKCK
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="text-primary mt-3">BNN (Tes Narkoba)</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal BNN</label>
                                                <input type="date" name="tanggal_bnn" class="form-control" value="{{ old('tanggal_bnn', optional($karyawan)->tanggal_bnn) }}">
                                                @if($karyawan->tanggal_bnn)
                                                <small class="text-muted">Terakhir: {{ formatDate($karyawan->tanggal_bnn) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File BNN</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file_bnn" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                        <label class="custom-file-label">Pilih file baru (opsional)</label>
                                                    </div>
                                                </div>
                                                @if($karyawan->file_bnn)
                                                <div class="mt-2">
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                                    <br>
                                                    <a href="{{ getFileUrl($karyawan->file_bnn, 'bnn') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-eye"></i> Lihat BNN
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB DRIVER/SATPAM -->
                                @if($showDriverSatpam)
                                <div class="tab-pane" id="driver-satpam">
                                    @if($isDriver)
                                    <h5 class="text-primary"><i class="fas fa-car mr-1"></i> Driver (SIM A)</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No SIM A</label>
                                                <input type="text" name="no_sim_a" class="form-control" value="{{ old('no_sim_a', optional($karyawan)->no_sim_a) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Masa Berlaku SIM</label>
                                                <input type="date" name="masa_berlaku_sim" class="form-control" value="{{ old('masa_berlaku_sim', optional($karyawan)->masa_berlaku_sim) }}">
                                                @if($karyawan->masa_berlaku_sim)
                                                <small class="text-muted">Terakhir: {{ formatDate($karyawan->masa_berlaku_sim) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File SIM</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file_sim" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                        <label class="custom-file-label">Pilih file baru (opsional)</label>
                                                    </div>
                                                </div>
                                                @if($karyawan->file_sim)
                                                <div class="mt-2">
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                                    <br>
                                                    <a href="{{ getFileUrl($karyawan->file_sim, 'sim') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-eye"></i> Lihat SIM
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jumlah Tilang </label>
                                                <input type="number" name="jumlah_tilang_6_bulan" class="form-control" value="{{ old('jumlah_tilang_6_bulan', optional($karyawan)->jumlah_tilang_6_bulan) }}" min="0">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($isSatpam)
                                    <h5 class="text-primary mt-3"><i class="fas fa-shield-alt mr-1"></i> Satpam (KTA & Sertifikat Garda)</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No KTA</label>
                                                <input type="text" name="no_kta" class="form-control" value="{{ old('no_kta', optional($karyawan)->no_kta) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Masa Berlaku KTA</label>
                                                <input type="date" name="masa_berlaku_kta" class="form-control" value="{{ old('masa_berlaku_kta', optional($karyawan)->masa_berlaku_kta) }}">
                                                @if($karyawan->masa_berlaku_kta)
                                                <small class="text-muted">Terakhir: {{ formatDate($karyawan->masa_berlaku_kta) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File KTA</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file_kta" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                        <label class="custom-file-label">Pilih file baru (opsional)</label>
                                                    </div>
                                                </div>
                                                @if($karyawan->file_kta)
                                                <div class="mt-2">
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                                    <br>
                                                    <a href="{{ getFileUrl($karyawan->file_kta, 'kta') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-eye"></i> Lihat KTA
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Pangkat Garda</label>
                                                <select name="pangkat_garda" class="form-control">
                                                    <option value=""> Pilih </option>
                                                    <option value="pratama" {{ old('pangkat_garda', optional($karyawan)->pangkat_garda) == 'pratama' ? 'selected' : '' }}>Pratama</option>
                                                    <option value="madya" {{ old('pangkat_garda', optional($karyawan)->pangkat_garda) == 'madya' ? 'selected' : '' }}>Madya</option>
                                                    <option value="utama" {{ old('pangkat_garda', optional($karyawan)->pangkat_garda) == 'utama' ? 'selected' : '' }}>Utama</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No Sertifikat Garda</label>
                                                <input type="text" name="no_sertifikat_garda" class="form-control" value="{{ old('no_sertifikat_garda', optional($karyawan)->no_sertifikat_garda) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File Sertifikat Garda</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file_sertifikat_garda" class="custom-file-input" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                        <label class="custom-file-label">Pilih file baru (opsional)</label>
                                                    </div>
                                                </div>
                                                @if($karyawan->file_sertifikat_garda)
                                                <div class="mt-2">
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> File tersimpan</small>
                                                    <br>
                                                    <a href="{{ getFileUrl($karyawan->file_sertifikat_garda, 'garda') }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-eye"></i> Lihat Sertifikat
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endif

                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                            <!--
                            <a href="{{ route('karyawan.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
-->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection
