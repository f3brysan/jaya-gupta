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
                <h1>Rekapitulasi Perkiraan Pensiun</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="3">Jenjang</th>
                                        </tr>
                                        <tr>
                                            @foreach ($tahun as $thn)
                                                <th class="text-center" colspan="2">{{ $thn['tahun'] }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($tahun as $item)
                                                <th>Negeri</th>
                                                <th>Swasta</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>                                      
                                        @foreach ($data as $bp)                                            
                                            <tr>
                                                <td>{{ $bp['nama'] }}</td>
                                                @foreach ($tahun as $thn)
                                                    @foreach ($data as $th)
                                                        @if ($th['nama'] == $bp['nama'])    
                                                        @php
                                                            if ( $th['tahun'][$thn['tahun']]['Negeri'] == 0) {
                                                                $btn_mode = 'disabled';
                                                            } else {
                                                                $btn_mode = '';
                                                            }

                                                            if ( $th['tahun'][$thn['tahun']]['Swasta'] == 0) {
                                                                $btn_modex = 'disabled';
                                                            } else {
                                                                $btn_modex = '';
                                                            }
                                                            
                                                        @endphp                                                  
                                                            <td class="text-center"><a class="btn btn-link {{ $btn_mode }}" href="{{ URL::to('rekap/data-pensiun/negeri/'.$thn['tahun'].'/'.$th['nama']) }}" >{{ $th['tahun'][$thn['tahun']]['Negeri'] }}</a></td>
                                                            <td class="text-center"><a class="btn btn-link {{ $btn_modex }} href="{{ URL::to('rekap/data-pensiun/swasta/'.$thn['tahun'].'/'.$th['nama']) }}">{{ $th['tahun'][$thn['tahun']]['Swasta'] }}</a></td>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">Total</th>
                                            @foreach ($tahun as $thn)
                                                    @foreach ($total as $th => $value)
                                                        @if ($th == $thn['tahun'])
                                                            <td class="text-center" colspan="2">{{ $value['Total'] }}</td>                                                                                                                        
                                                        @endif
                                                    @endforeach
                                                @endforeach                                  
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
    <script src="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
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
