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
                                        <form action="{{ URL::to('biodata/simpan') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{ $biodata->id }}">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label>Nama Lengkap <code>*Tanpa Gelar</code></label>
                                                        <input type="text" class="form-control" name="nama_lengkap"
                                                            value="{{ $biodata->nama_lengkap }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Gelar Depan</label>
                                                        <input type="text" class="form-control" name="gelar_depan"
                                                            value="{{ $biodata->gelar_depan }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label for="">Gelar Belakang</label>
                                                        <input type="text" name="gelar_blkg" class="form-control" id=""
                                                            value="{{ $biodata->gelar_belakang }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <label>NIP</label>
                                                        <input type="text" name="nip" class="form-control"
                                                            value="{{ $biodata->nip }}">
                                                    </div>
                                                </div>                                               
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <label>Jenis Kelamin</label>
                                                        <select name="gender" id="gender" class="form-control" required>
                                                            @if ($biodata->gender == null)
                                                                <option value="">Pilih</option>
                                                                <option value="L">Pria</option>
                                                                <option value="W">Wanita</option>
                                                            @elseIF ($biodata->gender == 'W')
                                                                <option value="L">Pria</option>
                                                                <option value="W" selected>Wanita</option>
                                                            @else
                                                                <option value="L" selected>Pria</option>
                                                                <option value="W">Wanita</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>                                                
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <label>Tanggal Lahir</label>
                                                        <input type="date" class="form-control" name="tanggallahir"
                                                            value="{{ $biodata->tanggallahir }}">
                                                    </div>
                                                </div>                                                                                                                                              
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <label>No WA</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $biodata->wa }}" id="wa" name="wa"
                                                            onkeypress="return isNumber(event)" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12 mb-2">
                                                        <label for="">Preview</label>
                                                        <br>
                                                        <img id="preview-image-before-upload"
                                                            src="{{ URL::to('/') }}/{{ $biodata->profile_picture }}"
                                                            alt="preview image" style="max-height: 250px;">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Foto Profil</label>
                                                        <input type="file" name="image" placeholder="Choose image"
                                                            id="image">
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary float-right"
                                                    id="btn-submit">
                                                    Simpan</button>
                                            </div>
                                        </form>
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
                                                        value="{{ Crypt::encrypt($biodata->id) }}">
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
            $('#tempatlahir').val('{{ $biodata->tempatlahir }}').trigger('change');
            $('#provdom').val('{{ $biodata->provdom }}').trigger('change');
            $('#kabdom').val('{{ $biodata->kabdom }}').trigger('change');
            $('#kecdom').val('{{ $biodata->kecdom }}').trigger('change');
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
                            $('#kabdom').val('{{ $biodata->kabdom }}').trigger('change');
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
                            $('#kecdom').val('{{ $biodata->kecdom }}').trigger('change');
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
