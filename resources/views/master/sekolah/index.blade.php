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
                <h1>Data Sekolah di Denpasar</h1>
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
                            <table id="example" class="table table-bordered table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" rowspan="2">No</th>
                                        <th class="text-center" rowspan="2" style="width: 250px !important">Wilayah</th>
                                        <th class="text-center" rowspan="1">Total</th>
                                        <th class="text-center" rowspan="1">TK</th>
                                        <th class="text-center" rowspan="1">KB</th>
                                        <th class="text-center" rowspan="1">TPA</th>
                                        <th class="text-center" rowspan="1">SPS</th>
                                        <th class="text-center" rowspan="1">PKBM</th>
                                        <th class="text-center" rowspan="1">SKB</th>
                                        <th class="text-center" rowspan="1">SD</th>
                                        <th class="text-center" rowspan="1">SMP</th>
                                        <th class="text-center" rowspan="1">SMA</th>
                                        <th class="text-center" rowspan="1">SMK</th>
                                        <th class="text-center" rowspan="1">SLB</th>
                                    </tr>
                                    <tr>
                                        <th>Jml</th>                                                                        
                                        <th>Jml</th>                                                                        
                                        <th>Jml</th>                                                                        
                                        <th>Jml</th>                                                                        
                                        <th>Jml</th>                                                                        
                                        <th>Jml</th>                                                                        
                                        <th>Jml</th>                                                                        
                                        <th>Jml</th>                                                                        
                                        <th>Jml</th>                                                                        
                                        <th>Jml</th>                                                                        
                                        <th>Jml</th>                                                                        
                                        <th>Jml</th>                                                                        
                                    </tr>
                                </thead>
                                <tbody>            
                                    @php
                                    $tk_n = 0;
                                    $tk_s = 0;
                                    $tk = 0;
                                    $kb_n = 0;
                                    $kb_s = 0;
                                    $kb = 0;
                                    $tpa_n = 0;
                                    $tpa_s = 0;
                                    $tpa = 0;
                                    $sps_n = 0;
                                    $sps_s = 0;
                                    $sps = 0;
                                    $pkbm_n = 0;
                                    $pkbm_s = 0;
                                    $pkbm = 0;
                                    $skb_n = 0;
                                    $skb_s = 0;
                                    $skb = 0;
                                    $sd_n = 0;
                                    $sd_s = 0;
                                    $sd = 0;
                                    $smp_n = 0;
                                    $smp_s = 0;
                                    $smp = 0;
                                    $sma_n = 0;
                                    $sma_s = 0;
                                    $sma = 0;
                                    $smk_n = 0;
                                    $smk_s = 0;
                                    $smk = 0;
                                    $slb_n = 0;
                                    $slb_s = 0;
                                    $slb = 0;
                                    $sekolah_n = 0;
                                    $sekolah_s = 0;
                                    $sekolah = 0;
                                @endphp                        
                                    @foreach ($getData as $item)
                                        <tr>
                                            <td class="text-right">{{ $loop->iteration }}</td>
                                            <td>
                                                @php
                                                    $kode_wil = trim($item['kode_wil']);
                                                    $kode_wil = Crypt::encrypt($kode_wil);
                                                @endphp
                                                <a href="{{ URL::to('data-sekolah/show/' . $item['id_level_wilayah'] . '/' . $kode_wil) }}"
                                                    target="_blank">{{ $item['nama'] }}</a>
                                            </td>
                                            <td class="text-right">{{ $item['total'] }} @php
                                                $sekolah += $item['total'];
                                            @endphp</td>                                            
                                            <td class="text-right">{{ $item['TK'] }} @php
                                                $tk += $item['TK'];
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['KB'] }} @php
                                                $kb += $item['KB'];
                                            @endphp</td>                                          
                                            <td class="text-right">{{ $item['TPA'] }} @php
                                                $tpa += $item['TPA'];
                                            @endphp</td>                                            
                                            <td class="text-right">{{ $item['SPS'] }} @php
                                                $sps += $item['SPS'];
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['PKBM'] }} @php
                                                $pkbm += $item['PKBM'];
                                            @endphp</td>                                
                                            <td class="text-right">{{ $item['SKB'] }} @php
                                                $skb += $item['SKB'];
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SD'] }} @php
                                                $sd += $item['SD'];
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SMP'] }} @php
                                                $smp += $item['SMP'];
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SMA'] }} @php
                                                $sma += $item['SMA'];
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SMK'] }} @php
                                                $smk += $item['SMK'];
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SLB'] }} @php
                                                $slb += $item['SLB'];
                                            @endphp</td>                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center" colspan="2">Total</th>
                                        <td class="text-right">{{ $sekolah }}</td>                                        
                                        <td class="text-right">{{ $tk }}</td>                                        
                                        <td class="text-right">{{ $kb }}</td>                                       
                                        <td class="text-right">{{ $tpa }}</td>                                       
                                        <td class="text-right">{{ $sps }}</td>                                       
                                        <td class="text-right">{{ $pkbm }}</td>                                        
                                        <td class="text-right">{{ $skb }}</td>                                       
                                        <td class="text-right">{{ $sd }}</td>                                       
                                        <td class="text-right">{{ $smp }}</td>                                       
                                        <td class="text-right">{{ $sma }}</td>                                        
                                        <td class="text-right">{{ $smk }}</td>                                        
                                        <td class="text-right">{{ $slb }}</td>                                        
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
