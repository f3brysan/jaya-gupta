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
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-hover table-bordered" style="padding: 10px; width: 100%;">
                                <thead>
                                    <tr>
                                       <th class="text-center">No</th>
                                       <th class="text-center">Nama Sekolah</th>
                                       <th class="text-center">NPSN</th>
                                       <th class="text-center">BP</th>
                                       <th class="text-center">Status</th>                                                                              
                                       <th class="text-center">PD</th>
                                       <th class="text-center">Rombel</th>
                                       <th class="text-center">Guru</th>
                                       <th class="text-center">Pegawai</th>
                                       <th class="text-center">R. Kelas</th>
                                       <th class="text-center">R. Lab</th>
                                       <th class="text-center">R. Perpus</th>
                                    </tr>                                   
                                </thead>
                                <tbody>                                                                  
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center" colspan="5">Total</th>                                                                                                                 
                                        <th class="text-right">{{ $total['pd'] }}</th>
                                        <th class="text-right">{{ $total['rombel'] }}</th>
                                        <th class="text-right">{{ $total['ptk'] }}</th>
                                        <th class="text-right">{{ $total['pegawai'] }}</th>
                                        <th class="text-right">{{ $total['jml_rk'] }}</th>
                                        <th class="text-right">{{ $total['jml_lab'] }}</th>
                                        <th class="text-right">{{ $total['jml_perpus'] }}</th>
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
            var url      = window.location.href; 
            $('#example').DataTable({
                processing: true,
                serverSide: true, //aktifkan server-side 
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
                        data: 'pd',
                        name: 'pd',
                        className: 'text-right',
                    },     
                    {
                        data: 'rombel',
                        name: 'rombel',
                        className: 'text-right',
                    },            
                    {
                        data: 'ptk',
                        name: 'ptk',
                        className: 'text-right',
                    },    
                    {
                        data: 'pegawai',
                        name: 'pegawai',
                        className: 'text-right',
                    },  
                    {
                        data: 'jml_rk',
                        name: 'jml_rk',
                        className: 'text-right',
                    },  
                    {
                        data: 'jml_lab',
                        name: 'jml_lab',
                        className: 'text-right',
                    },  
                    {
                        data: 'jml_perpus',
                        name: 'jml_perpus',
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
    </script>
@endpush
