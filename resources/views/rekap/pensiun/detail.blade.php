@extends('layouts.main')

@section('title', 'Rekapitulasi Perkiraan Pensiun')
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
                <h1>Rekapitulasi Perkiraan Pensiun Tahun {{ $thn }}</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Guru</th>
                                            <th class="text-center">Asal Sekolah</th>
                                            <th class="text-center">Pangkat Gol</th>
                                            <th class="text-center">Tanggal Lahir</th>
                                            <th class="text-center">Tanggal Pensiun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getBio as $item)
                                            <tr>
                                                <td class="text-right">{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->nm_sekolah }}</td>
                                                <td class="text-center">{{ $item->golongan }}</td>
                                                <td class="text-center">{{ $item->tanggallahir }}</td>
                                                <td class="text-center">@php
                                                    $date = date_create($item->tanggallahir);
                                                @endphp {{ $thn }}={{ date_format($date, 'm') }}-{{ date_format($date, 'd') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Guru</th>
                                            <th class="text-center">Asal Sekolah</th>
                                            <th class="text-center">Pangkat Gol</th>
                                            <th class="text-center">Tanggal Lahir</th>
                                            <th class="text-center">Tanggal Pensiun</th>
                                        </tr>
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
            $('#example').DataTable({
                "paging": false
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
