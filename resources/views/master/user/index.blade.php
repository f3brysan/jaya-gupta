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
                        <div class="float-right">
                            <a href="javascript:void(0)" class="btn btn-primary mb-3" id="add-btn"> Tambah</a>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-hover table-bordered"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
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
            });
        });

        $("#add-btn").click(function() {
            $("#tambah-edit-modal").modal('show');
            $("#modal-judul").html("Tambah Mata Pelajaran Baru");
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

        $(document).on('click', ".delete",function() {
            var dataId = $(this).data('id');
            var dataName = $(this).data('name');
            console.log(dataId);
            swal({
                title: 'Apakah Anda Yakin?',
                text: 'Data akan dihapus',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((isConfirm) => {
                if (isConfirm) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ URL::to('master/mata-pelajaran/delete') }}/" + dataId,
                        success: function(data) {
                            var oTable = $("#example").dataTable();
                            oTable.fnDraw(false);
                            iziToast.success({
                                title: 'Berhasil !',
                                message: "Data Mata Pelajaran " + dataName +
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
