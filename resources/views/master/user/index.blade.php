@extends('layouts.main')

@section('title', 'Data Mata Pelajaran')
@push('css-custom')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Pengguna</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="col-md-12">
                            <div class="float-left mt-2">
                                <a href="javascript:void(0)" class="btn btn-primary mb-3" id="add-btn"> Tambah</a>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">NUPTK</th>
                                            <th class="text-center">Nama Pengguna</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Peran</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambah-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-judul"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah-edit">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <div class="control-label">Peran</div>
                            <select class="js-example-basic-multiple form-control" id="roles" name="roles[]"
                                multiple="multiple" style="width: 100%" required>
                                @foreach ($roles as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="tombol-simpan">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambah-modal" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambah-judul"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{URL::to('master/user/store')}}" method="POST">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <div class="control-label">Email</div>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <div class="control-label">Nama</div>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <div class="control-label">NUPTK</div>
                            <input type="text" id="nuptk" name="nuptk" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <div class="control-label">Password</div>
                            <input type="text" id="password" name="password" class="form-control" value="12345678" readonly>
                        </div>
                        <div class="form-group">
                            <div class="control-label">Peran</div>
                            <select class="js-example-basic-multiple2 form-control" id="newroles" name="newroles[]"
                                multiple="multiple" style="width: 100%" required>
                                @foreach ($rolesToAdd as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="control-label">Asal Sekolah </div>
                            <code style="font-size: 8pt">*Untuk Kepala Sekolah, Operator, dan Tendik. Harap memilih asal sekolah.</code>
                            <select name="asal_satuan_sekolah" id="asal_satuan_sekolah" class="form-control js-example-basic-single" style="width: 100%">
                                <option value="">Pilih</option>
                                @foreach ($schools as $item)
                                    <option value="{{ $item->npsn }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('js-custom')
    <!-- JS Libraies -->
    <script src="{{ URL::to('/') }}/assets/modules/datatables/datatables.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                processing: true,
                serverSide: true, //aktifkan server-side 
                ajax: {
                    url: "{{ URL::to('master/user') }}", // routing ke group.index
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-right'
                    },
                    {
                        data: 'nuptk',
                        name: 'nuptk',
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [1, 'asc']
                ]
            });

            $(document).ready(function() {
                $('.js-example-basic-multiple').select2({
                    theme: "classic",
                });
                $('.js-example-basic-multiple2').select2({
                    theme: "classic",
                });
                $('.js-example-basic-single').select2();
            });
        });

        $("#add-btn").click(function() {
            $("#tambah-modal").modal('show');
            $("#tambah-judul").html("Tambah Pengguna Baru");
        });

        // ** TAMBAH DATA BARU * //
        if ($("#form-tambah-edit").length > 0) {
            $("#form-tambah-edit").validate({
                submitHandler: function(form) {
                    var actionType = $('#tombol-simpan').val();
                    $('#tombol-simpan').html('Menyimpan . .');

                    $.ajax({
                        type: "POST",
                        url: "{{ URL::to('master/user-role/store') }}",
                        data: $('#form-tambah-edit').serializeArray(),
                        dataType: 'json',
                        success: function(data) {
                            $('#form-tambah-edit').trigger("reset");
                            $('#tambah-edit-modal').modal("hide");
                            $('#tombol-simpan').html('Simpan');
                            var oTable = $('#example').dataTable();
                            oTable.fnDraw(false);
                            if (data == false) {
                                iziToast.danger({
                                    title: 'Berhasil !',
                                    message: "Peran " + data +
                                        " berhasil disimpan.",
                                    position: 'topRight'
                                });
                            } else {
                                iziToast.success({
                                    title: 'Berhasil !',
                                    message: "Peran " + data +
                                        " berhasil disimpan.",
                                    position: 'topRight'
                                });
                            }

                        },
                        error: function(data) {
                            console.log('Error', data);
                            $('#tombol-simpan').html('Simpan');
                        }
                    });
                }
            });
        }

        // ** EDIT DATA * // 
        $("body").on("click", ".edit", function() {
            var data_id = $(this).data('id');
            var data_name = $(this).data('name');
            console.log(data_name);
            $.get("{{ URL::to('master/user-role') }}/" + data_id, function(data) {
                console.log(data);
                $("#modal-judul").html("Ubah Peran " + data_name);
                $("tombol-simpan").val("edit-post");
                $("#tambah-edit-modal").modal('show');
                $("#id").val(data_id);
                $("#roles").val(data).change();
            });
        });

        $(document).on("click", ".login-as", function () {
            var dataId = $(this).data('id');
            var dataName = $(this).data('name');
            swal({
                title: 'Login As',
                text: 'Masuk sebagai '+ dataName+' ?',
                icon: 'info',
                buttons: true,
                dangerMode: true,
            }).then((isConfirm) => {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "{{ URL::to('master/user/loginas') }}/" + dataId,
                        success: function(data) {                            
                            iziToast.success({
                                title: 'Berhasil !',
                                message: "Login sebgagai " + dataName +
                                    " berhasil.",
                                position: 'topRight'
                            });
                            window.location.replace("{{ URL::to('/') }}");
                        }
                    });
                } else {
                    iziToast.info({
                        title: 'Info',
                        message: 'Tidak ada yang terjadi.',
                        position: 'topRight'
                    });
                }
            });
        });

        $(document).on('click', ".delete", function() {
            var dataId = $(this).data('id');
            var dataName = $(this).data('name');
            console.log(dataId);
            swal({
                title: 'Apakah Anda Yakin?',
                text: 'User '+ dataName+' akan dihapus',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((isConfirm) => {
                if (isConfirm) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ URL::to('master/user/delete') }}/" + dataId,
                        success: function(data) {
                            var oTable = $("#example").dataTable();
                            oTable.fnDraw(false);
                            iziToast.success({
                                title: 'Berhasil !',
                                message: "Data User " + dataName +
                                    " berhasil dihapus.",
                                position: 'topRight'
                            });
                        }
                    });
                } else {
                    iziToast.info({
                        title: 'Info',
                        message: 'Tidak ada perubahan yg disimpan.',
                        position: 'topRight'
                    });
                }
            });
        });
    </script>
@endpush
