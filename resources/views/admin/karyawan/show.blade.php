@extends('template.layout')

@section('content')

<section class="content">
    <div class="container-fluid">
        <!-- Header with Photo and Basic Info -->
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if($user->karyawan && $user->karyawan->foto_profil)
                                <img src="{{ asset('storage/' . $user->karyawan->foto_profil) }}" 
                                     alt="Foto Profil" 
                                     class="profile-user-img img-fluid img-circle"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" 
                                     alt="Foto Profil" 
                                     class="profile-user-img img-fluid img-circle"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @endif
                        </div>
                        <h3 class="profile-username text-center">
                            {{ $user->karyawan->nama_lengkap ?? $user->name }}
                        </h3>
                        <p class="text-muted text-center">
                            {{ $user->karyawan->jabatan->nama_jabatan ?? 'Belum ada jabatan' }}
                        </p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>NIP</b> <a class="float-right">{{ $user->karyawan->nip ?? '-' }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Status</b> 
                                <a class="float-right">
                                    @if($user->karyawan && $user->karyawan->is_complete)
                                        <span class="badge badge-success">Lengkap</span>
                                    @else
                                        <span class="badge badge-warning">Belum Lengkap</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                        <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Nav tabs -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Data Karyawan - {{ $user->karyawan->nama_lengkap ?? $user->name }}</h3>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="data-kerja-tab" data-toggle="pill" href="#data-kerja" role="tab">Data Kerja</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="data-pribadi-tab" data-toggle="pill" href="#data-pribadi" role="tab">Data Pribadi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="data-fisik-tab" data-toggle="pill" href="#data-fisik" role="tab">Data Fisik</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="kontak-tab" data-toggle="pill" href="#kontak" role="tab">Kontak</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pendidikan-tab" data-toggle="pill" href="#pendidikan" role="tab">Pendidikan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="identitas-tab" data-toggle="pill" href="#identitas" role="tab">Identitas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="bank-tab" data-toggle="pill" href="#bank" role="tab">Bank & BPJS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="dokumen-tab" data-toggle="pill" href="#dokumen" role="tab">Dokumen</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pengalaman-tab" data-toggle="pill" href="#pengalaman" role="tab">Pengalaman</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="kesehatan-tab" data-toggle="pill" href="#kesehatan" role="tab">Kesehatan</a>
                            </li>
                            @if($user->karyawan && $user->karyawan->jabatan)
                                @if(in_array($user->karyawan->jabatan->kode_jabatan, ['03', '06']))
                                <li class="nav-item">
                                    <a class="nav-link" id="khusus-tab" data-toggle="pill" href="#khusus" role="tab">
                                        {{ $user->karyawan->jabatan->kode_jabatan == '03' ? 'Satpam' : 'Driver' }}
                                    </a>
                                </li>
                                @endif
                            @endif
                        </ul>

                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <!-- DATA KERJA -->
                            <div class="tab-pane fade show active" id="data-kerja" role="tabpanel">
                                <table class="table table-borderless mt-3">
                                    <tr>
                                        <th width="30%">NIP</th>
                                        <td>{{ $user->karyawan->nip ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Unit PLN</th>
                                        <td>{{ $user->karyawan->unitpln->nama_unit ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sub Unit</th>
                                        <td>{{ $user->karyawan->subunit->nama_sub_unit ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td>{{ $user->karyawan->jabatan->nama_jabatan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tipe TAD</th>
                                        <td>{{ $user->karyawan->tad->nama_tad ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Project</th>
                                        <td>{{ $user->karyawan->project->nama_project ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Mulai Kerja</th>
                                        <td>{{ $user->karyawan->tanggal_mulai_kerja ? date('d-m-Y', strtotime($user->karyawan->tanggal_mulai_kerja)) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Kontrak</th>
                                        <td>{{ ucwords(str_replace('_', ' ', $user->karyawan->status_kontrak ?? '-')) }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- DATA PRIBADI -->
                            <div class="tab-pane fade" id="data-pribadi" role="tabpanel">
                                <table class="table table-borderless mt-3">
                                    <tr>
                                        <th width="30%">Nama Lengkap</th>
                                        <td>{{ $user->karyawan->nama_lengkap ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>{{ $user->karyawan->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td>{{ $user->karyawan->tempat_lahir ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>{{ $user->karyawan->tanggal_lahir ? date('d-m-Y', strtotime($user->karyawan->tanggal_lahir)) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Agama</th>
                                        <td>{{ $user->karyawan->agama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Nikah</th>
                                        <td>{{ ucwords(str_replace('_', ' ', $user->karyawan->status_nikah ?? '-')) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis TAD</th>
                                        <td>{{ $user->karyawan->tad->nama_tad ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- DATA FISIK -->
                            <div class="tab-pane fade" id="data-fisik" role="tabpanel">
                                <table class="table table-borderless mt-3">
                                    <tr>
                                        <th width="30%">Tinggi Badan</th>
                                        <td>{{ $user->karyawan->tinggi_badan ? $user->karyawan->tinggi_badan . ' cm' : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Berat Badan</th>
                                        <td>{{ $user->karyawan->berat_badan ? $user->karyawan->berat_badan . ' kg' : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Warna Kulit</th>
                                        <td>{{ $user->karyawan->warna_kulit ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Warna Rambut</th>
                                        <td>{{ $user->karyawan->warna_rambut ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bentuk Muka</th>
                                        <td>{{ $user->karyawan->bentuk_muka ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ciri Khas</th>
                                        <td>{{ $user->karyawan->ciri_khas ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- KONTAK -->
                            <div class="tab-pane fade" id="kontak" role="tabpanel">
                                <table class="table table-borderless mt-3">
                                    <tr>
                                        <th width="30%">No HP Utama</th>
                                        <td>{{ $user->karyawan->no_HP_utama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No HP Cadangan</th>
                                        <td>{{ $user->karyawan->no_HP_cadangan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email Pribadi</th>
                                        <td>{{ $user->karyawan->email_pribadi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ $user->karyawan->alamat ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Kontak Darurat</th>
                                        <td>{{ $user->karyawan->nama_kontak_darurat ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Kontak Darurat</th>
                                        <td>{{ $user->karyawan->nomor_darurat ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- PENDIDIKAN -->
                            <div class="tab-pane fade" id="pendidikan" role="tabpanel">
                                <table class="table table-borderless mt-3">
                                    <tr>
                                        <th width="30%">Pendidikan Terakhir</th>
                                        <td>{{ $user->karyawan->pendidikan->nama_pendidikan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Sekolah/Univ</th>
                                        <td>{{ $user->karyawan->nama_sekolah ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jurusan</th>
                                        <td>{{ $user->karyawan->jurusan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tahun Lulus</th>
                                        <td>{{ $user->karyawan->tahun_lulus ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>IPK/Nilai</th>
                                        <td>{{ $user->karyawan->nilai_ijazah ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- IDENTITAS RESMI -->
                            <div class="tab-pane fade" id="identitas" role="tabpanel">
                                <table class="table table-borderless mt-3">
                                    <tr>
                                        <th width="30%">NIK</th>
                                        <td>{{ $user->karyawan->nik ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>NPWP</th>
                                        <td>{{ $user->karyawan->npwp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No KK</th>
                                        <td>{{ $user->karyawan->no_kk ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No Akte Kelahiran</th>
                                        <td>{{ $user->karyawan->no_akte ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- BANK & BPJS -->
                            <div class="tab-pane fade" id="bank" role="tabpanel">
                                <table class="table table-borderless mt-3">
                                    <tr>
                                        <th width="30%">Nama Bank</th>
                                        <td>{{ $user->karyawan->nama_bank ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No Rekening</th>
                                        <td>{{ $user->karyawan->no_rg_bank ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No BPJS Kesehatan</th>
                                        <td>{{ $user->karyawan->no_bpjs ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No BPJS TK</th>
                                        <td>{{ $user->karyawan->no_bpjstk ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No BPLK</th>
                                        <td>{{ $user->karyawan->no_rek_bplk ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- DOKUMEN -->
                            <div class="tab-pane fade" id="dokumen" role="tabpanel">
                                <table class="table table-borderless mt-3">
                                    <tr>
                                        <th width="30%">Surat Lamaran</th>
                                        <td>
                                            @if($user->karyawan->file_surat_lamaran)
                                                <a href="{{ asset('storage/' . $user->karyawan->file_surat_lamaran) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>CV</th>
                                        <td>
                                            @if($user->karyawan->file_cv)
                                                <a href="{{ asset('storage/' . $user->karyawan->file_cv) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pakta Integritas</th>
                                        <td>
                                            @if($user->karyawan->file_pakta_integritas)
                                                <a href="{{ asset('storage/' . $user->karyawan->file_pakta_integritas) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Data Consist</th>
                                        <td>
                                            @if($user->karyawan->file_data_consist)
                                                <a href="{{ asset('storage/' . $user->karyawan->file_data_consist) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- PENGALAMAN KERJA -->
                            <div class="tab-pane fade" id="pengalaman" role="tabpanel">
                                <table class="table table-borderless mt-3">
                                    <tr>
                                        <th width="30%">Pengalaman Kerja 1</th>
                                        <td>{{ $user->karyawan->pengalaman_kerja_1 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pengalaman Kerja 2</th>
                                        <td>{{ $user->karyawan->pengalaman_kerja_2 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pengalaman Kerja 3</th>
                                        <td>{{ $user->karyawan->pengalaman_kerja_3 ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- KESEHATAN -->
                            <div class="tab-pane fade" id="kesehatan" role="tabpanel">
                                <table class="table table-borderless mt-3">
                                    <tr>
                                        <th width="30%">Tanggal MCU</th>
                                        <td>{{ $user->karyawan->tanggal_mcu ? date('d-m-Y', strtotime($user->karyawan->tanggal_mcu)) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>File Hasil MCU</th>
                                        <td>
                                            @if($user->karyawan->file_hasil_mcu)
                                                <a href="{{ asset('storage/' . $user->karyawan->file_hasil_mcu) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Perokok</th>
                                        <td>{{ $user->karyawan->perokok ? 'Ya' : 'Tidak' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Penyakit Bawaan</th>
                                        <td>{{ $user->karyawan->penyakit_bawaan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal SKCK</th>
                                        <td>{{ $user->karyawan->tanggal_skck ? date('d-m-Y', strtotime($user->karyawan->tanggal_skck)) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>File SKCK</th>
                                        <td>
                                            @if($user->karyawan->file_skck)
                                                <a href="{{ asset('storage/' . $user->karyawan->file_skck) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal BNN</th>
                                        <td>{{ $user->karyawan->tanggal_bnn ? date('d-m-Y', strtotime($user->karyawan->tanggal_bnn)) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>File BNN</th>
                                        <td>
                                            @if($user->karyawan->file_bnn)
                                                <a href="{{ asset('storage/' . $user->karyawan->file_bnn) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- KHUSUS SATPAM (03) / DRIVER (06) -->
                            @if($user->karyawan && $user->karyawan->jabatan)
                                @if($user->karyawan->jabatan->kode_jabatan == '03')
                                <div class="tab-pane fade" id="khusus" role="tabpanel">
                                    <h5>Data Khusus Satpam</h5>
                                    <table class="table table-borderless mt-3">
                                        <tr>
                                            <th width="30%">No KTA</th>
                                            <td>{{ $user->karyawan->no_kta ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Masa Berlaku KTA</th>
                                            <td>{{ $user->karyawan->masa_berlaku_kta ? date('d-m-Y', strtotime($user->karyawan->masa_berlaku_kta)) : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>File KTA</th>
                                            <td>
                                                @if($user->karyawan->file_kta)
                                                    <a href="{{ asset('storage/' . $user->karyawan->file_kta) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Pangkat Garda</th>
                                            <td>{{ ucwords($user->karyawan->pangkat_garda ?? '-') }}</td>
                                        </tr>
                                        <tr>
                                            <th>No Sertifikat Garda</th>
                                            <td>{{ $user->karyawan->no_sertifikat_garda ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>File Sertifikat Garda</th>
                                            <td>
                                                @if($user->karyawan->file_sertifikat_garda)
                                                    <a href="{{ asset('storage/' . $user->karyawan->file_sertifikat_garda) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                @elseif($user->karyawan->jabatan->kode_jabatan == '06')
                                <div class="tab-pane fade" id="khusus" role="tabpanel">
                                    <h5>Data Khusus Driver</h5>
                                    <table class="table table-borderless mt-3">
                                        <tr>
                                            <th width="30%">No SIM A</th>
                                            <td>{{ $user->karyawan->no_sim_a ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Masa Berlaku SIM</th>
                                            <td>{{ $user->karyawan->masa_berlaku_sim ? date('d-m-Y', strtotime($user->karyawan->masa_berlaku_sim)) : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>File SIM</th>
                                            <td>
                                                @if($user->karyawan->file_sim)
                                                    <a href="{{ asset('storage/' . $user->karyawan->file_sim) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Tilang 6 Bulan</th>
                                            <td>{{ $user->karyawan->jumlah_tilang_6_bulan ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>

@endsection
