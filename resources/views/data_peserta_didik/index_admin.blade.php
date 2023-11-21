@extends('layouts.main')

@section('title', 'Data Peserta Didik')
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
                <h1>Data Peserta Didik di Denpasar</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">                    
                    <div class="card">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" rowspan="2">No</th>
                                        <th class="text-center" rowspan="2" style="width: 250px !important">Wilayah</th>
                                        <th class="text-center" colspan="3" rowspan="1">Total</th>
                                        <th class="text-center" colspan="3" rowspan="1">TK</th>
                                        <th class="text-center" colspan="3" rowspan="1">KB</th>
                                        <th class="text-center" colspan="3" rowspan="1">TPA</th>
                                        <th class="text-center" colspan="3" rowspan="1">SPS</th>
                                        <th class="text-center" colspan="3" rowspan="1">PKBM</th>
                                        <th class="text-center" colspan="3" rowspan="1">SKB</th>
                                        <th class="text-center" colspan="3" rowspan="1">SD</th>
                                        <th class="text-center" colspan="3" rowspan="1">SMP</th>
                                        <th class="text-center" colspan="3" rowspan="1">SMA</th>
                                        <th class="text-center" colspan="3" rowspan="1">SMK</th>
                                        <th class="text-center" colspan="3" rowspan="1">SLB</th>
                                    </tr>
                                    <tr>
                                        <th>Jml</th>  
                                        <th>L</th>
                                        <th>P</th>                                                                      
                                        <th>Jml</th>  
                                        <th>L</th>
                                        <th>P</th>                                                                      
                                        <th>Jml</th>  
                                        <th>L</th>
                                        <th>P</th>                                                                      
                                        <th>Jml</th>  
                                        <th>L</th>
                                        <th>P</th>                                                                      
                                        <th>Jml</th>  
                                        <th>L</th>
                                        <th>P</th>                                                                      
                                        <th>Jml</th>  
                                        <th>L</th>
                                        <th>P</th>                                                                      
                                        <th>Jml</th>  
                                        <th>L</th>
                                        <th>P</th>                                                                      
                                        <th>Jml</th>  
                                        <th>L</th>
                                        <th>P</th>                                                                      
                                        <th>Jml</th>  
                                        <th>L</th>
                                        <th>P</th>                                                                      
                                        <th>Jml</th>  
                                        <th>L</th>
                                        <th>P</th>                                                                      
                                        <th>Jml</th>  
                                        <th>L</th>
                                        <th>P</th>                                                                      
                                        <th>Jml</th>  
                                        <th>L</th>
                                        <th>P</th>                                                                                                                                                                                 
                                    </tr>
                                </thead>
                                <tbody>            
                                    @php
                                    $tk_l = 0;
                                    $tk_p = 0;
                                    $tk = 0;
                                    $kb_l = 0;
                                    $kb_p = 0;
                                    $kb = 0;
                                    $tpa_l = 0;
                                    $tpa_p = 0;
                                    $tpa = 0;
                                    $sps_l = 0;
                                    $sps_p = 0;
                                    $sps = 0;
                                    $pkbm_l = 0;
                                    $pkbm_p = 0;
                                    $pkbm = 0;
                                    $skb_l = 0;
                                    $skb_p = 0;
                                    $skb = 0;
                                    $sd_l = 0;
                                    $sd_p = 0;
                                    $sd = 0;
                                    $smp_l = 0;
                                    $smp_p = 0;
                                    $smp = 0;
                                    $sma_l = 0;
                                    $sma_p = 0;
                                    $sma = 0;
                                    $smk_l = 0;
                                    $smk_p = 0;
                                    $smk = 0;
                                    $slb_l = 0;
                                    $slb_p = 0;
                                    $slb = 0;
                                    $sekolah_l = 0;
                                    $sekolah_p = 0;
                                    $sekolah = 0;
                                @endphp                        
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-right">{{ $loop->iteration }}</td>
                                            <td>
                                                @php
                                                    $kode_wil = trim($item['kode_wil']);
                                                    $kode_wil = Crypt::encrypt($kode_wil);
                                                @endphp
                                                <a href="{{ URL::to('admin/data-peserta-didik/show/'.$kode_wil) }}"
                                                    target="_blank">{{ $item['nama'] }}</a>
                                            </td>
                                            <td class="text-right">{{ $item['total'] }} @php
                                                $sekolah += $item['total'];
                                            @endphp</td>                                            
                                            <td class="text-right">{{ $item['total_l'] }} @php
                                                $sekolah_l += $item['total_l'];
                                            @endphp</td>                                            
                                            <td class="text-right">{{ $item['total_p'] }} @php
                                                $sekolah_p += $item['total_p'];
                                            @endphp</td>                                            
                                            <td class="text-right">{{ $item['TK'] ?? '0'}} @php
                                                $tk += $item['TK'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['TK_l'] ?? '0'}} @php
                                                $tk_l += $item['TK_l'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['TK_p'] ?? '0'}} @php
                                                $tk_p += $item['TK_p'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['KB'] ?? '0'}} @php
                                                $kb += $item['KB'] ?? 0;
                                            @endphp</td>                                          
                                            <td class="text-right">{{ $item['KB_l'] ?? '0'}} @php
                                                $kb_l += $item['KB_l'] ?? 0;
                                            @endphp</td>                                          
                                            <td class="text-right">{{ $item['KB_p'] ?? '0'}} @php
                                                $kb_p += $item['KB_p'] ?? 0;
                                            @endphp</td>                                          
                                            <td class="text-right">{{ $item['TPA'] ?? '0'}} @php
                                                $tpa += $item['TPA'] ?? 0;
                                            @endphp</td>                                            
                                            <td class="text-right">{{ $item['TPA_l'] ?? '0'}} @php
                                                $tpa_l += $item['TPA_l'] ?? 0;
                                            @endphp</td>                                            
                                            <td class="text-right">{{ $item['TPA_p'] ?? '0'}} @php
                                                $tpa_p += $item['TPA_p'] ?? 0;
                                            @endphp</td>                                            
                                            <td class="text-right">{{ $item['SPS'] ?? '0'}} @php
                                                $sps += $item['SPS'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SPS_l'] ?? '0'}} @php
                                                $sps_l += $item['SPS_l'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SPS_p'] ?? '0'}} @php
                                                $sps_p += $item['SPS_p'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['PKBM'] ?? '0'}} @php
                                                $pkbm += $item['PKBM'] ?? 0;
                                            @endphp</td>                                
                                            <td class="text-right">{{ $item['PKBM_l'] ?? '0'}} @php
                                                $pkbm_l += $item['PKBM_l'] ?? 0;
                                            @endphp</td>                                
                                            <td class="text-right">{{ $item['PKBM_p'] ?? '0'}} @php
                                                $pkbm_p += $item['PKBM_p'] ?? 0;
                                            @endphp</td>                                
                                            <td class="text-right">{{ $item['SKB'] ?? '0'}} @php
                                                $skb += $item['SKB'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SKB_l'] ?? '0'}} @php
                                                $skb_l += $item['SKB_l'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SKB_p'] ?? '0'}} @php
                                                $skb_p += $item['SKB_p'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SD'] ?? '0'}} @php
                                                $sd += $item['SD'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SD_l'] ?? '0'}} @php
                                                $sd_l += $item['SD_l'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SD_p'] ?? '0'}} @php
                                                $sd_p += $item['SD_p'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SMP'] ?? '0'}} @php
                                                $smp += $item['SMP'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SMP_l'] ?? '0'}} @php
                                                $smp_l += $item['SMP_l'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SMP_p'] ?? '0'}} @php
                                                $smp_p += $item['SMP_p'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SMA'] ?? '0'}} @php
                                                $sma += $item['SMA'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SMA_l'] ?? '0'}} @php
                                                $sma_l += $item['SMA_l'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SMA_p'] ?? '0'}} @php
                                                $sma_p += $item['SMA_p'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SMK'] ?? '0'}} @php
                                                $smk += $item['SMK'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SMK_l'] ?? '0'}} @php
                                                $smk_l += $item['SMK_l'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SMK_p'] ?? '0'}} @php
                                                $smk_p += $item['SMK_p'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SLB'] ?? '0'}} @php
                                                $slb += $item['SLB'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SLB_l'] ?? '0'}} @php
                                                $slb_l += $item['SLB_l'] ?? 0;
                                            @endphp</td>                                           
                                            <td class="text-right">{{ $item['SLB_p'] ?? '0'}} @php
                                                $slb_p += $item['SLB_p'] ?? 0;
                                            @endphp</td>                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center" colspan="2">Total</th>
                                        <td class="text-right">{{ $sekolah }}</td>                                        
                                        <td class="text-right">{{ $sekolah_l }}</td>                                        
                                        <td class="text-right">{{ $sekolah_p }}</td>                                        
                                        <td class="text-right">{{ $tk }}</td>                                        
                                        <td class="text-right">{{ $tk_l }}</td>                                        
                                        <td class="text-right">{{ $tk_p }}</td>                                        
                                        <td class="text-right">{{ $kb }}</td>                                       
                                        <td class="text-right">{{ $kb_l }}</td>                                       
                                        <td class="text-right">{{ $kb_p }}</td>                                       
                                        <td class="text-right">{{ $tpa }}</td>                                       
                                        <td class="text-right">{{ $tpa_l }}</td>                                       
                                        <td class="text-right">{{ $tpa_p }}</td>                                       
                                        <td class="text-right">{{ $sps }}</td>                                       
                                        <td class="text-right">{{ $sps_l }}</td>                                       
                                        <td class="text-right">{{ $sps_p }}</td>                                       
                                        <td class="text-right">{{ $pkbm }}</td>                                        
                                        <td class="text-right">{{ $pkbm_l }}</td>                                        
                                        <td class="text-right">{{ $pkbm_p }}</td>                                        
                                        <td class="text-right">{{ $skb }}</td>                                       
                                        <td class="text-right">{{ $skb_l }}</td>                                       
                                        <td class="text-right">{{ $skb_p }}</td>                                       
                                        <td class="text-right">{{ $sd }}</td>                                       
                                        <td class="text-right">{{ $sd_l }}</td>                                       
                                        <td class="text-right">{{ $sd_p }}</td>                                       
                                        <td class="text-right">{{ $smp }}</td>                                       
                                        <td class="text-right">{{ $smp_l }}</td>                                       
                                        <td class="text-right">{{ $smp_p }}</td>                                       
                                        <td class="text-right">{{ $sma }}</td>                                        
                                        <td class="text-right">{{ $sma_l }}</td>                                        
                                        <td class="text-right">{{ $sma_p }}</td>                                        
                                        <td class="text-right">{{ $smk }}</td>                                        
                                        <td class="text-right">{{ $smk_l }}</td>                                        
                                        <td class="text-right">{{ $smk_p }}</td>                                        
                                        <td class="text-right">{{ $slb }}</td>                                        
                                        <td class="text-right">{{ $slb_l }}</td>                                        
                                        <td class="text-right">{{ $slb_p }}</td>                                        
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
