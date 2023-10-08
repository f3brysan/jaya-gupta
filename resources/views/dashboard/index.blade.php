@extends('layouts.main')

@section('title', 'Beranda')

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Beranda</h1>
            </div>
            @if (auth()->user()->hasRole('guru'))
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="card author-box card-primary">
                            <div class="card-body">
                                <div class="author-box-left">
                                    <img alt="image" src="assets/img/avatar/avatar-1.png"
                                        class="rounded-circle author-box-picture">
                                    <div class="clearfix"></div>                                    
                                </div>
                                <div class="author-box-details">
                                    <div class="author-box-name">
                                        <a href="#">{{ auth()->user()->bio->nama }}</a>
                                    </div>
                                    <div class="author-box-job">{{ auth()->user()->bio->nip ?? ''}} ({{ auth()->user()->bio->asal_sekolah->nama_satuan ?? 'Belum Diset' }})</div>
                                    <div class="author-box-description">
                                        @foreach (auth()->user()->bio->user_bidang_pengembangan  as $item)
                                            <li>{{ $item->bidangpengembangan->nama }}</li>
                                        @endforeach
                                    </div>                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-flag"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Inovasi/Aksi Nyata</h4>
                                </div>
                                <div class="card-body">
                                    {{ $data['all'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="far fa-smile"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Inovasi/Aksi Nyata Lolos</h4>
                                </div>
                                <div class="card-body">
                                    {{ $data['terima'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="far fa-frown"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Inovasi/Aksi Nyata Tidak Lolos</h4>
                                </div>
                                <div class="card-body">
                                    {{ $data['tolak'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Menunggu Penilaian</h4>
                                </div>
                                <div class="card-body">
                                    {{ $data['waiting'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-flag"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Seluruh Inovasi/Aksi Nyata</h4>
                                </div>
                                <div class="card-body">
                                    {{ $data['all'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="far fa-smile"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Inovasi/Aksi Nyata Lolos</h4>
                                </div>
                                <div class="card-body">
                                    {{ $data['terima'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="far fa-frown"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Inovasi/Aksi Nyata Tidak Lolos</h4>
                                </div>
                                <div class="card-body">
                                    {{ $data['tolak'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Menunggu Penilaian</h4>
                                </div>
                                <div class="card-body">
                                    {{ $data['waiting'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">

                    <div class="card">
                        <div class="card-header">
                            <h5>Data Praktik baik</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Judul</th>
                                            <th class="text-center">Deskripsi</th>
                                            <th class="text-center">Gambar</th>
                                            <th class="text-center">Bidang Pengembangan</th>
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

        <section class="section">
            <div class="section-header">

            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-bullhorn"></i> Informasi</h4>
                        </div>
                        <div class="card-body">
                            <div id="accordion">
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-1">
                                        <h4>Petunjuk Teknis Inovasi Praktik Baik</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion">
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                            eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                    </div>
                                </div>
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-2">
                                        <h4>Petunjuk Teknis Aksi Nyata Praktik Baik</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-2" data-parent="#accordion">
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                            eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                    </div>
                                </div>
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-3">
                                        <h4>Persyaratan Kurasi</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-3" data-parent="#accordion">
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                            eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    url: "{{ URL::to('get-praktik-baik') }}", // routing ke group.index
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-right'
                    },
                    {
                        data: 'judul',
                        name: 'judul',
                    },
                    {
                        data: 'deskripsi_readmore',
                        name: 'deskripsi_readmore',
                    },
                    {
                        data: 'images',
                        name: 'images',
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
                        url: "{{ URL::to('master/bidang-pengembangan/store') }}",
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
            $.get("{{ URL::to('master/bidang-pengembangan/edit') }}/" + data_id, function(data) {
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

        $(document).on('click', ".delete", function() {
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
                        url: "{{ URL::to('master/bidang-pengembangan/delete') }}/" + dataId,
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
