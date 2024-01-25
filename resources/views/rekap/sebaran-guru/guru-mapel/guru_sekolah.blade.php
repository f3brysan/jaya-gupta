@extends('layouts.main')

@section('title', 'Rekapitulasi Sebaran Guru Kelas'.$bentuk_pendidikan.' '.$status_sekolah)
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
                <h1>Rekapitulasi Sebaran Guru Kelas {{ $bentuk_pendidikan }} {{ $status_sekolah }}</h1>
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
                                            <th class="text-center">Nama Sekolah</th>
                                            <th class="text-center">Kelebihan / Kekuarngan JP</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php                                        
                                            $total_kjp = 0;                                            
                                        @endphp
                                        @foreach ($getData as $item)
                                        @php
                                            // $total_guru += $item->guru_kelas;     
                                            $jp = $item->tot_rombel * $mata_pelajaran->jam_pelajaran;
                                            $jg = $item->tot_pns + $item->tot_pppk + $item->tot_kd;
                                            $kjp = $jp - ($jg*24);      
                                            $total_kjp += $kjp;                        
                                        @endphp
                                            <tr>
                                                <td class="text-center"><b>{{ $loop->iteration }}</b></td>
                                                <td class="text-left"><a href="{{ URL::to('rekap/data-sebaran-guru/mapel/detil-guru-mapel/'.$item->npsn.'/'.$mata_pelajaran->nama) }}" class="btn btn-link">({{ $item->npsn }}) {{ $item->nama }}</a></td>
                                                <td class="text-center">{{ $kjp }} JP</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>                                        
                                            <th colspan="2" class="text-center">Jumlah</th>                                            
                                            <th class="text-center">{{ $total_kjp }} JP</th>
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
                // "paging": false
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
