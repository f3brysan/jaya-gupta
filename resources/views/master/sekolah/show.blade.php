@extends('layouts.main')

@section('title', 'Data Sekolah')
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
                <h1>Data Sekolah di {{ $nm_induk_kecamatan }}</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-info mb-2 alert-dismissible fade show" role="alert"
                        style="margin-bottom: 20px">
                        Data Sekolah bersumber dari <code>dapo.kemdikbud.go.id</code>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary pull-right float-right m-2" id="pull_data_btn"
                                    onclick="pullData('{{ $kode_wil }}')">Tarik data dapo ke database</button>
                            </div>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table id="example" class="table table-bordered table-hover table-bordered"
                                style="padding: 10px; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Sekolah</th>
                                        <th class="text-center">NPSN</th>
                                        <th class="text-center">BP</th>
                                        <th class="text-center">Status</th>                                       
                                        <th class="text-center">Guru</th>
                                        <th class="text-center">Pegawai</th>                                        
                                    </tr>
                                </thead>
                                <tbody>                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center" colspan="5">Total</th>                                       
                                        <th class="text-right">{{ $total['ptk'] }}</th>
                                        <th class="text-right">{{ $total['pegawai'] }}</th>                                       
                                    </tr>
                                </tfoot>
                            </table>
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
    <script>
        $(document).ready(function() {
            var url = window.location.href;
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                processing: true,
                // serverSide: true, //aktifkan server-side 
                ajax: {
                    url: url, // routing ke group.index
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
                        data: 'npsn',
                        name: 'npsn',
                    },
                    {
                        data: 'bentuk_pendidikan',
                        name: 'bentuk_pendidikan',
                    },
                    {
                        data: 'status_sekolah',
                        name: 'status_sekolah',
                    },                    
                    {
                        data: 'total_guru',
                        name: 'total_guru',
                        className: 'text-right',
                    },
                    {
                        data: 'pegawai',
                        name: 'pegawai',
                        className: 'text-right',
                    },                    
                ],
                order: [
                    [0, 'asc']
                ]
            });
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

        function pullData(kode_wil) {
            console.log(kode_wil);
            var txt_button = `<i class="fa fa-circle-o-notch fa-spin"></i> Proses Sinkron. Harap Tunggu sebentar . . .`;
            $("#pull_data_btn").html(txt_button);
            $('#pull_data_btn').prop('disabled', true);
            $("#pull_data_btn").removeClass("btn-primary");
            $("#pull_data_btn").addClass("btn-secondary");
            $.ajax({
                type: "POST",
                url: "{{ URL::to('data-sekolah/pull-data') }}",
                data: {
                    'kode_wil': kode_wil,
                    '_token': "{{ csrf_token() }}",
                },
                success: function(ress) {
                    console.log(ress);
                    $("#pull_data_btn").removeClass("btn-secondary");
                    $("#pull_data_btn").addClass("btn-primary btn-glow");
                    $("#pull_data_btn").html("Tarik data dapo ke database");
                    $('#pull_data_btn').prop('disabled', false);
                    var oTable = $('#example').dataTable();
                    oTable.fnDraw(false);
                    swal("Info", ress + " data berhasil disinkron", "success");
                }
            });
        }
    </script>
@endpush
