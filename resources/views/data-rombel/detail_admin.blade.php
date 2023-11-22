@extends('layouts.main')

@section('title', 'Data Rombongan Belajar')
@push('css-custom')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/izitoast/css/iziToast.min.css">
@endpush

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Rombongan Belajar {{ $sekolah->nama }}</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-left">
                                <a href="{{ URL::to('data-rombel/tambah') }}" class="btn btn-primary mb-3"><i
                                        class="fa fa-plus"></i> Tambah</a>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'No'}">
                                                <div>No</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Nama Rombel'}">
                                                <div>Nama Rombel</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Tingkat Kelas'}">
                                                <div>Tingkat Kelas</div>
                                            </th>
                                            <th class="text-center" rowspan="1" colspan="3"
                                                data-sheets-value="{'1':2,'2':'Jumlah Siswa'}">Jumlah Siswa</th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Wali Kelas'}">
                                                <div>Wali Kelas</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Kurikulum'}">
                                                <div>Kurikulum</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Ruangan'}">
                                                <div>Ruangan</div>
                                            </th>                                            
                                        </tr>
                                        <tr>
                                            <th class="text-center" data-sheets-value="{'1':2,'2':'L'}">L</th>
                                            <th class="text-center" data-sheets-value="{'1':2,'2':'P'}">P</th>
                                            <th class="text-center" data-sheets-value="{'1':2,'2':'Total'}">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kelas as $k)
                                            <tr>
                                                <td class="text-right">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $k['nama_rombel'] }}</td>
                                                <td class="text-center">{{ $k['tingkat_kelas'] }}</td>
                                                <td class="text-right">{{ $k['L'] }}</td>
                                                <td class="text-right">{{ $k['P'] }}</td>
                                                <td class="text-right">{{ $k['total'] }}</td>
                                                <td class="text-eflt">{{ $k['nm_wali'] }} <br> NUPTK :
                                                    {{ $k['wali_kelas'] }}</td>
                                                <td data-sheets-value="{'1':2,'2':'Kurikulum SD Merdeka'}">
                                                    {{ $k['kurikulum'] }}
                                                </td>
                                                <td data-sheets-value="{'1':2,'2':'Ruang Kelas 1 A'}">{{ $k['ruangan'] }}
                                                </td>                                                
                                            </tr>
                                        @endforeach

                                    </tbody>
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
    <script src="{{ URL::to('/') }}/assets/modules/izitoast/js/iziToast.min.js"></script>
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
    @if (session()->has('success'))
        <script>
            $(document).ready(function() {
                iziToast.success({
                    title: 'Berhasil !',
                    message: "{{ session('success') }}",
                    position: 'topRight'
                });
            });
        </script>
    @endif
@endpush
