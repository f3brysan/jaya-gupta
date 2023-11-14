@extends('layouts.main')

@section('title', 'Data Sekolah')
@push('css-custom')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/select2/dist/css/select2.min.css">
@endpush

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Guru</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5> Data Guru</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ URL('data-guru/simpan') }}" method="POST">
                                @csrf
                                <h6>Profil Guru</h6>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nama Guru <code>*Tanpa Gelar</code></label>
                                        <input type="text" class="form-control" name="nama_lengkap">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Gelar Depan</label>
                                        <input type="text" class="form-control" name="gelar_depan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Gelar Belakang</label>
                                        <input type="text" name="gelar_blkg" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Jenis Kelamin</label>
                                        <select name="gender" id="gender" class="form-control" required>                                          
                                                <option value="">Pilih</option>
                                                <option value="L">Laki - Laki</option>
                                                <option value="P">Perempuan</option>                                          
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Asal Sekolah</label>
                                        <select name="asal_satuan" class="form-control select2" id="">
                                            <option value="">-- Pilih Asal Sekolah --</option>
                                            @foreach ($asal_satuan as $item)
                                                <option value="{{ $item->npsn }}">{{ $item->npsn.' - '.$item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">NUPTK</label>
                                        <input type="text" name="nuptk" class="form-control" id="" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Tempat Lahir</label>                                        
                                        <select name="tempatlahir" id="tempatlahir" class="form-control select2">
                                            <option value="">Pilih Tempat Lahir</option>
                                            @foreach ($kab as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Tanggal Lahir</label>
                                        <input type="date" name="tgllahir" class="form-control" id="" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">NIP</label>
                                        <input type="text" name="nip" class="form-control" id="" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Status Kepagawaian</label>
                                        <input type="text" name="status_kepegawaian" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Jenjang Pendidikan Terakhir</label>
                                        <select name="jenjang" class="form-control" id="">
                                            <option value="">-- Pilih Jenjang --</option>                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Jurusan/Prodi Pendidikan</label>
                                        <input type="text" name="jurusan" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Mengajar</label>
                                        <input type="text" name="mengajar" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Sertifikasi</label>
                                        <input type="text" name="sertifikasi" class="form-control" id="">
                                    </div>
                                </div>
                                <h6>Domisili</h6>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Provinsi</label>
                                        <select name="provdom" id="provdom" class="form-control select2">
                                            <option value=""></option>
                                            @foreach ($prov as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Kabupaten</label>
                                        <select name="kabdom" id="kabdom" class="form-control select2">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Kecamatan</label>
                                        <select name="kecdom" id="kecdom" class="form-control select2">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Kelurahan</label>
                                        <select name="keldom" id="keldom" class="form-control select2">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Alamat/Nama Dusun</label>
                                        <input type="text" class="form-control" name="desadom">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Kodepos</label>
                                        <input type="text" class="form-control" name="kodepos" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <h6>Narahubung</h6>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">No Telepon</label>
                                        <input type="text" class="form-control" name="telepon" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">No HP/WA</label>
                                        <input type="text" class="form-control" name="wa" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Email</label>
                                        <input type="text" class="form-control" name="email">
                                    </div>
                                </div>
                                <h6>Kepegawaian</h6>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Tugas Tambahan</label>
                                        <input type="text" class="form-control" name="tugas_tambahan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">SK CPNS</label>
                                        <input type="text" class="form-control" name="sk_cpns">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Tanggal CPNS</label>
                                        <input type="date" class="form-control" name="tgl_cpns">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">SK Pengangkatan</label>
                                        <input type="text" class="form-control" name="sk_pengangkatan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">TMT Pengangkatan</label>
                                        <input type="date" class="form-control" name="tmt_pengangkatan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Lembaga Pengangkatan</label>
                                        <input type="text" class="form-control" name="lembaga_pengangkatan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Pangkat Golongan</label>
                                        <select name="golongan" class="form-control" id="">
                                            <option value="">-- Pilih Pangkat Golongan --</option>
                                            @foreach ($pangkat as $item)
                                                <option value="{{ $item->gol }}">{{ $item->pangkat.' - '.$item->gol }}</option>
                                            @endforeach
                                        </select>                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Sumber Gaji</label>
                                        <input type="text" class="form-control" name="sumber_gaji">
                                    </div>
                                </div>
                                <h6>Keluarga/Pribadi</h6>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Nama Ibu Kandung</label>
                                        <input type="text" class="form-control" name="nm_ibu">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Status Perkawinan</label>
                                        <select name="status_perkawinan" id="" class="form-control">
                                            <option value="">-- Pilih Status Perkawinan --</option>                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Nama Suami/Istri</label>
                                        <input type="text" class="form-control" name="nm_pasangan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">NIP Suami/Istri</label>
                                        <input type="text" class="form-control" name="nip_pasangan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Pekerjaan Suami/Istri</label>
                                        <input type="text" class="form-control" name="pekerjaan_pasangan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">TMT PNS</label>
                                        <input type="text" class="form-control" name="tmt_pns">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">NPWP</label>
                                        <input type="text" class="form-control" name="npwp">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Bank</label>
                                        <input type="text" class="form-control" name="bank">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Nomor Rekening Bank</label>
                                        <input type="text" class="form-control" name="norek_bank">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Rekening Atas Nama</label>
                                        <input type="text" class="form-control" name="nama_norek">
                                    </div>
                                </div>                               
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">NIK (Nomor Induk Kependudukan)</label>
                                        <input type="text" class="form-control" name="nik" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">No KK</label>
                                        <input type="text" class="form-control" name="no_kk">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Guru Penggerak</label>
                                       <select name="is_penggerak" class="form-control" id="">
                                        <option value="0">Tidak</option>
                                        <option value="1">Iya</option>
                                       </select>
                                    </div>
                                </div>
                                <h6>Lain - Lain</h6>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Jam Tugas Tambahan</label>
                                        <input type="text" class="form-control" name="jam_tgs_tambahan" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">JJM</label>
                                        <input type="text" class="form-control" name="jjm" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Siswa</label>
                                        <input type="text" class="form-control" name="siswa" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Status Sekolah</label>
                                        <input type="text" class="form-control" name="status_sekolah">
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
            </div>
        </section>
    </div>

@endsection
@push('js-custom')
    <!-- JS Libraies -->
    <script src="{{ URL::to('/') }}/assets/modules/datatables/datatables.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js">
    </script>
    <script src="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {

        });

        $('.hapus-btn').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            swal({
                title: 'Apakah Anda Yakin?',
                text: 'Data akan dihapus',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((isConfirm) => {
                if (isConfirm) {
                    swal('Data Telah dihapus', {
                        icon: 'success',
                    });
                    if (isConfirm) form.submit();
                } else {
                    swal('Tidak Ada perubahan');
                }
            });
        });

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
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
                            
                        } else {
                            $("#kecdom").empty();
                        }
                    }
                });
            } else {
                $("#kecdom").empty();
            }
        });

        $('#kecdom').change(function() {
            var id = $(this).val();
            if (id) {
                $.ajax({
                    type: "GET",
                    url: "/ajax/getkelurahan/" + id,
                    dataType: 'JSON',
                    success: function(res) {
                        if (res) {
                            $("#keldom").empty();
                            $("#keldom").append('<option>--- Pilih Kelurahan ---</option>');
                            $.each(res, function(name, id) {
                                $("#keldom").append('<option value="' + id + '">' + name +
                                    '</option>');
                            });
                            
                        } else {
                            $("#keldom").empty();
                        }
                    }
                });
            } else {
                $("#keldom").empty();
            }
        });
    </script>
@endpush