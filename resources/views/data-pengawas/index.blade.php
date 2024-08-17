@extends('layouts.main')

@section('title', 'Data Pengawas')
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
                <h1>Data Pengawas di Denpasar</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">                    
                    <div class="card">
                        <div class="card-body">
                            <div class="float-left mb-4">
                                <a href="{{ URL::to('admin/data-pengawas/tambah') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover table-bordered">
                                    <thead>
                                        <tr>
                                         <th>Aksi</th>
                                         <th>No</th>
                                         <th>Nama</th>
                                         <th>NIP</th>
                                         <th>Pangkat/Golongan</th>
                                         <th>Tempat Lahir</th>
                                         <th>Tanggal Lahir</th>
                                         <th>Usia Pensiun</th>
                                         <th>Tanggal Pensiun</th>
                                         <th>Jenis Sertifikat</th>
                                         <th>Kecamatan</th>
                                         <th>Jenjang</th>
                                         <th>Sekolah Binaan</th>                                                                                                                                                                       
                                        </tr>
                                    </thead>
                                    <tbody>    
                                        @foreach ($getPengawas as $item)
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach                                                                                                 
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Aksi</th>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIP</th>
                                            <th>Pangkat/Golongan</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Usia Pensiun</th>
                                            <th>Tanggal Pensiun</th>
                                            <th>Jenis Sertifikat</th>
                                            <th>Kecamatan</th>
                                            <th>Jenjang</th>
                                            <th>Sekolah Binaan</th>    
                                    </tfoot>
                                </table>
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
    <script src="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js">
    </script>
    <script src="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
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
