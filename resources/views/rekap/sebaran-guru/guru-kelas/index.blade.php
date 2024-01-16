@extends('layouts.main')

@section('title', 'Rekapitulasi Sebaran Guru')
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
                <h1>Rekapitulasi Sebaran Guru Kelas {{ $bentuk_pendidikan }}</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Status Sekolah</th>
                                            <th>Jumlah Rombel</th>
                                            <th>Jumlah Guru Kelas</th>
                                            <th>Kekurangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_rombel = 0;
                                            $total_guru = 0;
                                            $total_kekurangan = 0;
                                        @endphp
                                        @foreach ($getData as $item)
                                        @php
                                            $total_rombel += $item->tot_rombel;
                                            $total_guru += $item->guru_kelas;
                                        @endphp
                                            <tr>
                                                <td class="text-center"><b>{{ $item->status_sekolah }}</b></td>
                                                <td class="text-right"><a href="{{ URL::to('rekap/data-sebaran-guru/kelas/rombel/'.$bentuk_pendidikan.'/'.$item->status_sekolah) }}">{{ $item->tot_rombel }}</a></td>
                                                <td class="text-right"><a href="{{ URL::to('rekap/data-sebaran-guru/kelas/guru-kelas/'.$bentuk_pendidikan.'/'.$item->status_sekolah) }}">{{ $item->guru_kelas }}</a></td>
                                                <td class="text-center">
                                                    @if ($item->tot_rombel > $item->guru_kelas)
                                                    @php
                                                        $margin = $item->tot_rombel - $item->guru_kelas;
                                                        $total_kekurangan += $margin;
                                                    @endphp
                                                        <a href="{{ URL::to('rekap/data-sebaran-guru/kelas/kekurangan/'.$bentuk_pendidikan.'/'.$item->status_sekolah) }}" target="_blank" class="badge badge-danger">Guru Kelas kurang sebanyak :
                                                            {{ $item->tot_rombel - $item->guru_kelas }} Orang</a>
                                                    @elseif($item->tot_rombel == $item->guru_kelas)
                                                        <span class="badge badge-success">Pas/Cukup</span>
                                                    @else
                                                        <span class="badge badge-warning">Guru kelas berlebih sebanyak :
                                                            {{ $item->guru_kelas - $item->tot_rombel }} Orang</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Jumlah</th>
                                            <th class="text-right">{{ $total_rombel }}</th>
                                            <th class="text-right">{{ $total_guru }}</th>
                                            <th class="text-right">{{ $total_kekurangan }}</th>
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
