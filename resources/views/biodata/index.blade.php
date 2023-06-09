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
                <div class="col-lg-12">
                    <div class="card">
                        <form action="/biodata/simpan" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $biodata->id }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Nama Pengguna</label>
                                        <input type="text" name="nama" class="form-control"
                                            value="{{ $biodata->nama }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Tempat Lahir</label>
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
                                        <label>Tempat Lahir</label>
                                        <select name="tempatlahir" id="tempatlahir" class="form-control select2">
                                            <option value=""></option>
                                            @foreach ($kab as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
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
                                        <label>Provinsi Domisili</label>
                                        <select name="provdom" id="provdom" class="form-control select2">
                                            <option value=""></option>
                                            @foreach ($prov as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Kabupaten Domisili</label>
                                        <select name="kabdom" id="kabdom" class="form-control select2">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Kecamatan Domisili</label>
                                        <select name="kecdom" id="kecdom" class="form-control select2">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <label>Alamat Domisili</label>
                                        <textarea class="form-control" name="alamatdom" id="alamatdom" cols="30" rows="15">{!! $biodata->alamatdom !!}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>No WA</label>
                                        <input type="text" class="form-control" value="{{ $biodata->wa }}"
                                            id="wa" name="wa" onkeypress="return isNumber(event)" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right" id="btn-submit">
                                    Simpan</button>
                            </div>
                        </form>                        
                    </div>
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
@endpush
