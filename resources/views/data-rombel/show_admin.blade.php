@extends('layouts.main')

@section('title', 'Data Rombel')
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
                <h1>Data R di {{ $data_kec->induk_kecamatan }}</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">                   
                    <div class="card">
                        <div class="row">                           
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table id="example" class="table table-bordered table-hover table-bordered"
                                style="padding: 10px; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Sekolah</th>
                                        <th class="text-center">NPSN</th>
                                        <th class="text-center">BP</th>
                                        <th class="text-center">Status</th>                                       
                                        <th class="text-center">Rombongan Belajar</th>                                                                         
                                    </tr>
                                </thead>
                                <tbody>  
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($query as $item)
                                        <tr>
                                            <td class="text-right">{{ $loop->iteration }}</td>
                                            <td><a href="{{ URL::to('admin/data-rombel/detail/'.$item->npsn) }}">{{ $item->nama }}</a></td>
                                            <td>{{ $item->npsn }}</td>
                                            <td>{{ $item->bentuk_pendidikan }}</td>
                                            <td>{{ $item->status_sekolah }}</td>
                                            <td class="text-right">{{ $item->tot }}
                                            @php
                                                $total += $item->tot;
                                            @endphp</td>
                                        </tr>
                                    @endforeach                                  
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" colspan="5">Total</th>                                                                               
                                        <th class="text-right">{{ $total }}</th>                                       
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
            var url = window.location.href;
            $('#example').DataTable({
                dom: 'Blfrtip'                         
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

        function pullData(kode_wil) {
            console.log(kode_wil);
            var txt_button = `<i class="fa fa-circle-o-notch fa-spin"></i> Proses Sinkron. Harap Tunggu sebentar . . .`;
            $("#pull_data_btn").html(txt_button);
            $('#pull_data_btn').prop('disabled', true);
            $("#pull_data_btn").removeClass("btn-primary");
            $("#pull_data_btn").addClass("btn-secondary");
            $.ajax({
                type: "POST",
                url: "{{ URL::to('data-sekolah/pull-data') }}",
                data: {
                    'kode_wil': kode_wil,
                    '_token': "{{ csrf_token() }}",
                },
                success: function(ress) {
                    console.log(ress);
                    $("#pull_data_btn").removeClass("btn-secondary");
                    $("#pull_data_btn").addClass("btn-primary btn-glow");
                    $("#pull_data_btn").html("Tarik data dapo ke database");
                    $('#pull_data_btn').prop('disabled', false);
                    var oTable = $('#example').dataTable();
                    oTable.fnDraw(false);
                    swal("Info", ress + " data berhasil disinkron", "success");
                }
            });
        }
    </script>
@endpush
