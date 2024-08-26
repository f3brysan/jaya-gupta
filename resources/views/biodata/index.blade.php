@extends('layouts.main')

@section('title', 'Biodata')

@push('css-custom')
    <link rel="stylesheet" href="assets/modules/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="assets/modules/bootstrap-daterangepicker/daterangepicker.css">
@endpush

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Biodata</h1>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Biodata </h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                        role="tab" aria-controls="home" aria-selected="true">Profil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                        aria-controls="profile" aria-selected="false">Kompetensi Bidang Pengembangan
                                        Keprofesian</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{ URL('biodata/simpan') }}" enctype="multipart/form-data"  method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ Crypt::encrypt($get->id) }}">
                                                <h6>Profil Guru</h6>
                                                <div class="form-group">
                                                    <div class="col-md-12">                                       
                                                     <div class="col-md-12">
                                                        <img id="preview-image-before-upload"
                                                        src="{{ URL::to('/') }}/{{ $get->profile_picture }}" alt="preview image"
                                                        style="max-height: 250px;">
                                                     </div>
                                                            <label class="mt-2">Foto Guru</label>
                                                        <input type="file" name="image" placeholder="Choose image" id="image"
                                                            accept="image/*" class="form-control @error('picture') is-invalid @enderror">
                                                        @error('picture')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label>Nama Guru <code>*Tanpa Gelar</code></label>
                                                        <input type="text" class="form-control" name="nama_lengkap"
                                                            value="{{ $get->nama_lengkap }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Gelar Depan</label>
                                                        <input type="text" class="form-control" name="gelar_depan"
                                                            value="{{ $get->gelar_depan }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Gelar Belakang</label>
                                                        <input type="text" name="gelar_blkg" class="form-control" id=""
                                                            value="{{ $get->gelar_belakang }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label>Jenis Kelamin</label>
                                                        <select name="gender" id="gender" class="form-control">
                                                            <option value="">Pilih</option>
                                                            <option value="L" {{ $get->gender == 'L' ? 'selected' : '' }}>Laki - Laki
                                                            </option>
                                                            <option value="W" {{ $get->gender == 'W' ? 'selected' : '' }}>Perempuan
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Asal Sekolah</label>
                                                        <select name="asal_satuan" class="form-control select2" id="">
                                                            <option value="">-- Pilih Asal Sekolah --</option>
                                                            @foreach ($asal_satuan as $item)
                                                                <option value="{{ $item->npsn }}"
                                                                    {{ $get->asal_satuan_pendidikan == $item->npsn ? 'selected' : '' }}>
                                                                    {{ $item->npsn . ' - ' . $item->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">NUPTK</label>
                                                        <input type="text" name="nuptk" class="form-control" id=""
                                                            onkeypress="return isNumber(event)" value="{{ $get->nuptk }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Tempat Lahir</label>
                                                        <input type="text" name="tempatlahir" class="form-control" id=""
                                                            value="{{ $get->tempatlahir }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Tanggal Lahir</label>
                                                        <input type="date" name="tgllahir" class="form-control" id=""
                                                            value="{{ $get->tanggallahir }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">NIP</label>
                                                        <input type="text" name="nip" class="form-control" id=""
                                                            value="{{ $get->nip }}" onkeypress="return isNumber(event)">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Status Kepagawaian</label>
                                                        <input type="text" name="status_kepegawaian" class="form-control"
                                                            id="" value="{{ $get->status_kepegawaian }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Jenjang Pendidikan Terakhir</label>
                                                        <select name="jenjang" class="form-control" id="">
                                                            <option value="">-- Pilih Jenjang --</option>
                                                            @foreach ($jenjang as $item)
                                                                <option value="{{ $item->kode }}"
                                                                    {{ $get->pendidikan_terakhir == $item->kode ? 'selected' : '' }}>
                                                                    {{ $item->kode }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Jurusan/Prodi Pendidikan</label>
                                                        <input type="text" name="jurusan" class="form-control" id=""
                                                            value="{{ $get->prodi }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Mengajar</label>
                                                        <select name="mengajar" class="form-control" id="">
                                                            <option value="">Pilih</option>
                                                            <option value="Guru Kelas" {{ 'Guru Kelas' == $get->mengajar ? 'selected' : '' }}>Guru Kelas</option>
                                                            @foreach ($mapel as $item)
                                                                <option value="{{ $item->nama }}" {{ $item->nama == $get->mengajar ? 'selected' : '' }}>{{ $item->nama }}</option>
                                                            @endforeach
                                                        </select>                                       
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Sertifikasi</label>
                                                        <input type="text" name="sertifikasi" class="form-control" id=""
                                                            value="{{ $get->sertifikasi }}">
                                                    </div>
                                                </div>
                                                <h6>Domisili</h6>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Kecamatan</label>
                                                        <input type="text" name="kecdom" class="form-control" id=""
                                                            value="{{ $get->kecdom }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Kelurahan</label>
                                                        <input type="text" name="keldom" class="form-control" id=""
                                                            value="{{ $get->keldom }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Alamat/Nama Dusun</label>
                                                        <input type="text" name="alamat" class="form-control" id=""
                                                            value="{{ $get->alamat }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Kodepos</label>
                                                        <input type="text" class="form-control" name="kodepos"
                                                            onkeypress="return isNumber(event)" value="{{ $get->kodepos }}">
                                                    </div>
                                                </div>
                                                <h6>Narahubung</h6>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">No Telepon</label>
                                                        <input type="text" class="form-control" name="telepon"
                                                            onkeypress="return isNumber(event)" value="{{ $get->telepon }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">No HP/WA</label>
                                                        <input type="text" class="form-control" name="wa"
                                                            onkeypress="return isNumber(event)" {{ $get->wa }}>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Email</label>
                                                        <input type="text" class="form-control" name="email"
                                                            value="{{ $get->user->email }}">
                                                    </div>
                                                </div>
                                                <h6>Kepegawaian</h6>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Tugas Tambahan</label>
                                                        <input type="text" class="form-control" name="tugas_tambahan"
                                                            value="{{ $get->tugas_tambahan }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">SK CPNS</label>
                                                        <input type="text" class="form-control" name="sk_cpns" {{ $get->sk_cpns }}>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Tanggal CPNS</label>
                                                        <input type="date" class="form-control" name="tgl_cpns"
                                                            value="{{ $get->tgl_cpns }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">SK Pengangkatan</label>
                                                        <input type="text" class="form-control" name="sk_pengangkatan"
                                                            value="{{ $get->sk_pengangkatan }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">TMT Pengangkatan</label>
                                                        <input type="date" class="form-control" name="tmt_pengangkatan"
                                                            value="{{ $get->tmt_pengangkatan }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Lembaga Pengangkatan</label>
                                                        <input type="text" class="form-control" name="lembaga_pengangkatan"
                                                            value="{{ $get->lembaga_pengangkatan }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Pangkat Golongan</label>
                                                        <input type="text" name="golongan" class="form-control" id=""
                                                            value="{{ $get->golongan }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Sumber Gaji</label>
                                                        <input type="text" class="form-control" name="sumber_gaji"
                                                            value="{{ $get->sumber_gaji }}">
                                                    </div>
                                                </div>
                                                <h6>Keluarga/Pribadi</h6>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Nama Ibu Kandung</label>
                                                        <input type="text" class="form-control" name="nm_ibu"
                                                            value="{{ $get->nm_ibu }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Status Perkawinan</label>
                                                        <input type="text" name="status_perkawinan" class="form-control"
                                                            id="" value="{{ $get->status_perkawinan }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Nama Suami/Istri</label>
                                                        <input type="text" class="form-control" name="nm_pasangan"
                                                            value="{{ $get->nm_pasangan }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">NIP Suami/Istri</label>
                                                        <input type="text" class="form-control" name="nip_pasangan"
                                                            value="{{ $get->nip_pasangan }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Pekerjaan Suami/Istri</label>
                                                        <input type="text" class="form-control" name="pekerjaan_pasangan"
                                                            value="{{ $get->pekerjaan_pasangan }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">TMT PNS</label>
                                                        <input type="text" class="form-control" name="tmt_pns"
                                                            value="{{ $get->tmt_pns }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">NPWP</label>
                                                        <input type="text" class="form-control" name="npwp"
                                                            value="{{ $get->npwp }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Bank</label>
                                                        <input type="text" class="form-control" name="bank"
                                                            value="{{ $get->bank }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Nomor Rekening Bank</label>
                                                        <input type="text" class="form-control" name="norek_bank"
                                                            value="{{ $get->norek_bank }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Rekening Atas Nama</label>
                                                        <input type="text" class="form-control" name="nama_norek"
                                                            value="{{ $get->nama_norek }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">NIK (Nomor Induk Kependudukan)</label>
                                                        <input type="text" class="form-control" name="nik"
                                                            onkeypress="return isNumber(event)" value="{{ $get->nik }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">No KK</label>
                                                        <input type="text" class="form-control" name="no_kk"
                                                            value="{{ $get->no_kk }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Guru Penggerak</label>
                                                        <input type="text" name="is_penggerak" class="form-control" id=""
                                                            value="{{ $get->is_penggerak }}">
                                                    </div>
                                                </div>
                                                <h6>Lain - Lain</h6>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Jam Tugas Tambahan</label>
                                                        <input type="text" class="form-control" name="jam_tgs_tambahan"
                                                            onkeypress="return isNumber(event)" value="{{ $get->jam_tgs_tambahan }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">JJM</label>
                                                        <input type="text" class="form-control" name="jjm"
                                                            onkeypress="return isNumber(event)" value="{{ $get->jjm }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Siswa</label>
                                                        <input type="text" class="form-control" name="siswa"
                                                            onkeypress="return isNumber(event)" value="{{ $get->siswa }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Status Sekolah</label>
                                                        <input type="text" class="form-control" name="status_sekolah"
                                                            value="{{ $get->status_sekolah }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-info pull-right float-right"><i
                                                            class="fa fa-save"></i>
                                                        Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <table class="table table-bordered table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <td class="text-right">No.</td>
                                                <td>Nama</td>
                                                <td>Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($bidang_pengembangan) < 1)
                                                <tr>
                                                    <td colspan="3" class="text-center"><span
                                                            class="badge badge-warning">Belum Ada Data</span></td>
                                                </tr>
                                            @else
                                                @foreach ($bidang_pengembangan as $item)
                                                    <tr>
                                                        <td class="text-right">{{ $loop->iteration }}</td>
                                                        <td>{{ $item->bidangpengembangan->nama }}</td>
                                                        <td><a href="javascript:void(0)" class="btn btn-danger delete"
                                                                onclick="hapusBidPengembangan('{{ $item->id }}', '{{ $item->bidangpengembangan->nama }}')"><i
                                                                    class="fa fa-trash"></i></a></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <form action="{{ URL::to('biodata/tambah-bidang-pengembangan') }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="bio_id"
                                                        value="{{ Crypt::encrypt($get->id) }}">
                                                    <td class="text-center"><span class="badge badge-info"> Tambah Data
                                                            Baru</span></td>
                                                    <td><select class="form-control select2" name="bidang_pengembangan_id"
                                                            style="width: 100%" required>
                                                            <option value="">-- Pilih Bidang Pengembangan --</option>
                                                            @foreach ($ms_bidang_pengembangan as $item)
                                                                <option value="{{ Crypt::encrypt($item->id) }}">
                                                                    {{ $item->nama }}</option>
                                                            @endforeach
                                                        </select></td>
                                                    <td><button type="submit" class="btn btn-primary float-center"
                                                            id="btn-submit">
                                                            <i class="fa fa-plus"></i></button></td>
                                                </form>
                                            </tr>
                                        </tbody>

                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                </div>
            </div>

        </section>
    </div>
@endsection

@push('js-custom')
    <script src="assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="assets/js/page/forms-advanced-forms.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tempatlahir').val('{{ $get->tempatlahir }}').trigger('change');
            $('#provdom').val('{{ $get->provdom }}').trigger('change');
            $('#kabdom').val('{{ $get->kabdom }}').trigger('change');
            $('#kecdom').val('{{ $get->kecdom }}').trigger('change');
        });
    </script>
    <script>
        $('#provdom').change(function() {
            var province_id = $(this).val();
            if (province_id) {
                $.ajax({
                    type: "GET",
                    url: "/ajax/getkabupaten/" + province_id,
                    dataType: 'JSON',
                    success: function(res) {
                        if (res) {
                            $("#kabdom").empty();
                            $("#kabdom").append('<option>--- Pilih Kabupaten ---</option>');
                            $.each(res, function(name, id) {
                                $("#kabdom").append('<option value="' + id + '">' + name +
                                    '</option>');
                            });
                            $('#kabdom').val('{{ $get->kabdom }}').trigger('change');
                        } else {
                            $("#kabdom").empty();
                        }
                    }
                });
            } else {
                $("#kabdom").empty();
            }
        });

        $('#kabdom').change(function() {
            var province_id = $(this).val();
            if (province_id) {
                $.ajax({
                    type: "GET",
                    url: "/ajax/getkecamatan/" + province_id,
                    dataType: 'JSON',
                    success: function(res) {
                        if (res) {
                            $("#kecdom").empty();
                            $("#kecdom").append('<option>--- Pilih Kecamatan ---</option>');
                            $.each(res, function(name, id) {
                                $("#kecdom").append('<option value="' + id + '">' + name +
                                    '</option>');
                            });
                            $('#kecdom').val('{{ $get->kecdom }}').trigger('change');
                        } else {
                            $("#kecdom").empty();
                        }
                    }
                });
            } else {
                $("#kecdom").empty();
            }
        });

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        $('#btn-submit').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            swal({
                    title: 'Apakah Anda Yakin?',
                    text: 'Data akan diubah, sesuai inputan',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((isConfirm) => {
                    if (isConfirm) {
                        swal('Data Telah Diubah', {
                            icon: 'success',
                        });
                        if (isConfirm) form.submit();
                    } else {
                        swal('Data tidak disimpan');
                    }
                });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#image').change(function() {

                let reader = new FileReader();

                reader.onload = (e) => {

                    $('#preview-image-before-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);

            });
        });
    </script>
    <script>
        function hapusBidPengembangan(id, nama) {
            console.log(id);
            swal({
                    title: 'Apakah Anda Yakin?',
                    text: 'Kompetensi ' + nama + ' akan dihapus.',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((isConfirm) => {
                    if (isConfirm) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ URL::to('biodata/hapus-bidang-pengembangan') }}/" + id,
                            success: function(data) {                               
                                swal("Berhasil", "Data telah terhapus", "success");
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                               
                            }
                        });                                                
                    } else {
                        swal('Data tidak disimpan');
                    }
                });
        }
    </script>
@endpush
