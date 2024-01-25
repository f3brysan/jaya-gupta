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
                <h1>Rekapitulasi Sebaran Guru {{ $bentuk_pendidikan }} Mapel {{ $mata_pelajaran->nama }}</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">STATUS SEKOLAH</th>
                                            <th rowspan="2" class="text-center">JUMLAH ROMBEL</th>
                                            <th rowspan="2" class="text-center">JP</th>
                                            <th rowspan="2" class="text-center">TOTAL JP</th>
                                            <th colspan="4" class="text-center">JUMLAH GURU</th>
                                            <th rowspan="2" class="text-center">KELEBIHAN/KEKURANGAN JP</th>
                                            <th rowspan="2" class="text-center">KELEBIHAN/KEKURANGAN GURU</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">PNS</th>
                                            <th class="text-center">PPPK</th>
                                            <th class="text-center">KONTRAK DAERAH</th>
                                            <th class="text-center">HONOR SEKOLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $tot_rombel = 0;
                                            $tot_jp = 0;
                                            $grandtot_jp = 0;
                                            $pns = 0;
                                            $pppk = 0;
                                            $kd = 0;
                                            $hs = 0;
                                            $tot_kjp = 0;
                                            $tot_kjg = 0;
                                        @endphp
                                        @foreach ($getData as $item)
                                            @php
                                                $jp = $item->tot_rombel * $mata_pelajaran->jam_pelajaran;
                                                $jg = $item->tot_pns + $item->tot_pppk + $item->tot_kd;
                                                $tot_jp += $mata_pelajaran->jam_pelajaran;
                                                $grandtot_jp += $jp;
                                                $tot_rombel += $item->tot_rombel;
                                                $kjp = $jp - $jg * 24;
                                                $kjg = $kjp/24;
                                                $pns += $item->tot_pns;
                                                $pppk += $item->tot_pppk;
                                                $kd += $item->tot_kd;
                                                $hs += $item->tot_hs;

                                                $tot_kjp += $kjp;
                                                $tot_kjg += $kjg;

                                            @endphp
                                            <tr>
                                                <td>{{ $item->status_sekolah }}</td>
                                                <td class="text-right">{{ $item->tot_rombel }}</td>
                                                <td class="text-right">{{ $mata_pelajaran->jam_pelajaran }}</td>
                                                <td class="text-right">{{ $jp }}</td>
                                                <td class="text-right">{{ $item->tot_pns }}</td>
                                                <td class="text-right">{{ $item->tot_pppk }}</td>
                                                <td class="text-right">{{ $item->tot_kd }}</td>
                                                <td class="text-right">{{ $item->tot_hs }}</td>
                                                <td class="text-right">
                                                    @if ($kjp >= 0)
                                                        <a href="{{ URL::to('rekap/data-sebaran-guru/mapel/sekolah/'.$mata_pelajaran->jenjang.'/'.$mata_pelajaran->nama.'/'.$item->status_sekolah) }}" target="_blank" class="text-black">+ {{ abs($kjp) }}</a>
                                                    @else
                                                        <a href="{{ URL::to('rekap/data-sebaran-guru/mapel/sekolah/'.$mata_pelajaran->jenjang.'/'.$mata_pelajaran->nama.'/'.$item->status_sekolah) }}" target="_blank" class="text-warning">-{{ abs($kjp) }}</a>
                                                    @endif
                                                </td>
                                                <td class="text-right">@if ($kjg <= 0)
                                                    <a href="" class="text-black">+ {{ abs($kjg) }}</a>
                                                @else
                                                    <a href="" class="text-red">- {{ abs($kjg) }}</a>
                                                @endif</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Jumlah</th>
                                            <th class="text-right">{{ $tot_rombel }}</th>
                                            <th class="text-right">{{ $tot_jp }}</th>
                                            <th class="text-right">{{ $grandtot_jp }}</th>
                                            <th class="text-right">{{ $pns }}</th>
                                            <th class="text-right">{{ $pppk }}</th>
                                            <th class="text-right">{{ $kd }}</th>
                                            <th class="text-right">{{ $hs }}</th>
                                            <th class="text-right"> @if ($tot_kjp >= 0)
                                                <a class="text-black">+ {{ abs($tot_kjp) }}</a>
                                            @else
                                                <a class="text-red">-{{ abs($tot_kjp) }}</a>
                                            @endif</th>
                                            <th class="text-right"> @if ($tot_kjg <= 0)
                                                <a class="text-black">+ {{ abs($tot_kjg) }}</a>
                                            @else
                                                <a class="text-red">-{{ abs($tot_kjg) }}</a>
                                            @endif</th>
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
