@extends('layouts.main')

@section('title', 'Edit Data Tendik')
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
                <h1>Edit Data Tendik {{ $get->nama }}</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Tendik</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ URL('data-tendik/update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ Crypt::encrypt($get->id) }}">
                                <h6>Profil Tendik</h6>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nama Tendik <code>*Tanpa Gelar</code></label>
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
                                            <option value="L" {{ $get->gender == 'L' ? 'selected' : '' }}>Laki - Laki</option>
                                            <option value="P" {{ $get->gender == 'P' ? 'selected' : '' }}>Perempuan</option>                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Asal Sekolah</label>
                                        <select name="asal_satuan" class="form-control select2" id="" readonly>
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
                                        <label for="">Jenis PTK</label>
                                        <input type="text" name="jenis_ptk" class="form-control" id=""
                                            value="{{ $get->jenis_ptk }}">
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
                                                    {{ $item->nama }}</option>
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
                                        <label for="">Sertifikasi</label>
                                        <input type="text" name="sertifikasi" class="form-control" id=""
                                            value="{{ $get->sertifikasi }}">
                                    </div>
                                </div>      
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">TMT Kerja</label>
                                        <input type="text" class="form-control" name="tmt_pns"
                                            value="{{ $get->tmt_pns }}">
                                    </div>
                                </div>                                                                                        
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Periode Penugasan (untuk Kepala Sekolah)</label>
                                        <select class="form-control" name="periode_penugasan" id="periode_penugasan">
                                            <option value="">Pilih</option>
                                            <option value="1" {{ $get->periode_penugasan == '1' ? 'selected' : ''}}>Pertama</option>
                                            <option value="2" {{ $get->periode_penugasan == '2' ? 'selected' : ''}}>Kedua</option>
                                            <option value="3" {{ $get->periode_penugasan == '3' ? 'selected' : ''}}>Ketiga</option>
                                            <option value="4" {{ $get->periode_penugasan == '4' ? 'selected' : ''}}>Keempat</option>
                                        </select>
                                    </div>
                                </div>                                                          
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Tendik Penggerak</label>
                                        <select name="is_penggerak" id="is_penggerak" class="form-control">
                                            <option value="iya" {{ $get->is_penggerak == 'iya' ? 'selected' : ''}}>Iya</option>
                                            <option value="tidak" {{ $get->is_penggerak == NULL || $get->is_penggerak == 'tidak' ? 'selected' : ''}}>Tidak</option>
                                        </select>                                       
                                    </div>
                                </div>      
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Angkatan GP</label>
                                        <select class="form-control" name="angkatan_gp" id="angkatan_gp">
                                            <option value="">Pilih</option>
                                            @for ($x = 0; $x <= 20; $x++)
                                            <option value="{{ $x }}" {{ $get->angkatan_gp == $x ? 'selected' : '' }}> {{ $x }}</option>
                                            @endfor                                    
                                        </select>
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
            $('#provdom').val('{{ $get->provdom }}').trigger('change');
            $('#kabdom').val('{{ $get->kabdom }}').trigger('change');
            $('#kecdom').val('{{ $get->kecdom }}').trigger('change');
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
                            $('#keldom').val('{{ $get->keldom }}').trigger('change');
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
