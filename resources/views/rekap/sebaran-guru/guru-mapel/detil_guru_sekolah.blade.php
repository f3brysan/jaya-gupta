@extends('layouts.main')

@section('title', 'Data Guru Kelas ' . $sekolah->nama)
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
                <h1>Data Guru Mapel {{ $mata_pelajaran->nama }} Di {{ $sekolah->nama }}</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">No</th>
                                            <th rowspan="2" class="text-center">Nama Guru Kelas</th>
                                            <th colspan="2" class="text-center">Status Kepegawaian</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">ASN</th>
                                            <th class="text-center">NON ASN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $tot_asn = 0;
                                            $tot_non_asn = 0;
                                        @endphp
                                        @foreach ($dataGuruKelas as $item)
                                            <tr>
                                                <td class="text-right">{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td class="text-center">
                                                    @if ($item->status_pns == 'ASN')
                                                        @php
                                                            $tot_asn += 1;
                                                        @endphp
                                                        <i class="fa fa-check"></i>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($item->status_pns == 'NON ASN')
                                                    @php
                                                        $tot_non_asn += 1;
                                                    @endphp
                                                    <i class="fa fa-check"></i>
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" class="text-center">Jumlah</th>
                                            <th class="text-center">{{ $tot_asn }}</th>
                                            <th class="text-center">{{ $tot_non_asn }}</th>                                            
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
