@extends('layouts.main')

@section('title', 'Data Mata Pelajaran')
@push('css-custom')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endpush

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Guru</h1>
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
                                        <th class="text-center">Nama Guru</th>
                                        <th class="text-center">Asal Sekolah</th>
                                        <th class="text-center">Email</th>
                                        <th>Bidang Pengembangan</th>
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
                            <label>Nama Mata Pelajaran</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <div class="control-label">Mata Pelajaran Aktif?</div>
                            <label class="custom-switch mt-2">
                                {{-- <span class="custom-switch-description">Tidak &nbsp;</span> --}}
                                <input type="checkbox" class="custom-switch-input"
                                    id="is_aktif" name="is_aktif" checked>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Iya</span>
                            </label>
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
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                processing: true,
                serverSide: true, //aktifkan server-side 
                ajax: {
                    url: "{{ URL::to('data-guru') }}", // routing ke group.index
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
                        data: 'asal_sekolah',
                        name: 'asal_sekolah',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'bidang_pengembangan',
                        name: 'bidang_pengembangan',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [0, 'asc']
                ]
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
                        url: "{{ URL::to('master/mata-pelajaran/store') }}",
                        data: $('#form-tambah-edit').serializeArray(),
                        dataType: 'json',
                        success: function(data) {
                            $('#form-tambah-edit').trigger("reset");
                            $('#tambah-edit-modal').modal("hide");
                            $('#tombol-simpan').html('Simpan');
                            var oTable = $('#example').dataTable();
                            oTable.fnDraw(false);
                            iziToast.success({
                                title: 'Berhasil !',
                                message: "Data Mata Pelajaran " + data.nama +
                                    " berhasil disimpan.",
                                position: 'topRight'
                            });
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
            $.get("{{ URL::to('master/mata-pelajaran/edit') }}/" + data_id, function(data) {
                $("#modal-judul").html("Edit Mata Pelajaran " + data.nama);
                $("tombol-simpan").val("edit-post");
                $("#tambah-edit-modal").modal('show');
                $("#id").val(data.id);
                $("#nama").val(data.nama);
                if (data.is_aktif === true) {
                    $('#is_aktif').prop('checked', true);
                } else {
                    $('#is_aktif').prop('checked', false);
                }
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
