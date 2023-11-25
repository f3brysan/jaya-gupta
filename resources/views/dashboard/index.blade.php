@extends('layouts.main')

@section('title', 'Beranda')

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Beranda</h1>
            </div>
            @if (auth()->user()->hasRole('guru'))
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="card author-box card-primary">
                            <div class="card-body">
                                <div class="author-box-left">
                                    <img alt="image" src="assets/img/avatar/avatar-1.png"
                                        class="rounded-circle author-box-picture">
                                    <div class="clearfix"></div>                                    
                                </div>
                                <div class="author-box-details">
                                    <div class="author-box-name">
                                        <a href="#">{{ auth()->user()->bio->nama }}</a>
                                    </div>
                                    <div class="author-box-job">{{ auth()->user()->bio->nip ?? ''}} ({{ auth()->user()->bio->asal_sekolah->nama ?? 'Belum Diset' }})</div>
                                    <div class="author-box-description">
                                        @foreach (auth()->user()->bio->user_bidang_pengembangan  as $item)
                                            <li>{{ $item->bidangpengembangan->nama }}</li>
                                        @endforeach
                                    </div>                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                           
            @endif

            @if (auth()->user()->hasRole(['kepalasekolah']))
            <div class="row">
                <div class="col-md-6">
                    <div class="card author-box card-primary">
                        <div class="card-body">                                                        
                                <div class="author-box-name">
                                    <h5><i class="fa fa-university"></i>{{ $dataSekolah->nama }}</h5>
                                </div>                               
                                <div class="author-box-description">
                                   <li>NPSN : {{ $dataSekolah->npsn }}</li>
                                   <li>Bentuk Pendidikan : {{ $dataSekolah->bentuk_pendidikan }}</li>
                                   <li>Status : {{ $dataSekolah->status_sekolah }}</li>
                                   <li>Kecamatan : {{ $dataSekolah->induk_kecamatan }}</li>
                                   <li>Kabupaten : {{ $dataSekolah->induk_kabupaten }}</li>
                                   <li>Provinsi : {{ $dataSekolah->induk_provinsi }}</li>
                                   <li>Kepala Sekolah : {{ $kepalasekolah ? $kepalasekolah->bio->nama : '' }}</li>
                                </div>                                                              
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card author-box card-primary">   
                        <div class="row" style="width: 99%">
                            <div class="col-sm-6">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="far fa-user"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Total GTK</h4>
                                        </div>
                                        <div class="card-body">
                                            {{ $jml['gtk'] }} Orang
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-sm-6">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Total Peserta Didik</h4>
                                        </div>
                                        <div class="card-body">
                                            {{ $jml['pd'] }} Siswa
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-sm-6">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fab fa-shirtsinbulk"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Total Rombel</h4>
                                        </div>
                                        <div class="card-body">
                                            {{ $jml['rombel'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>     
                            <div class="col-sm-6">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-person-booth"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Total Ruangan</h4>
                                        </div>
                                        <div class="card-body">
                                            {{ $jml['ruangan'] }} 
                                        </div>
                                    </div>
                                </div>
                            </div>     
                            </div>                     
                                           
                    </div>
                </div>
            </div> 
            @endif

            @if (auth()->user()->hasRole('superadmin'))
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Sekolah</h4>
                            </div>
                            <div class="card-body">
                               {{ $jml['sekolah_all'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total PNS</h4>
                            </div>
                            <div class="card-body">
                               {{ $jml['pns_all'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Pengawas</h4>
                            </div>
                            <div class="card-body">
                                NaN
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Peserta Didik</h4>
                            </div>
                            <div class="card-body">
                               {{ $jml['pd_all'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah GTK</h4>
                            </div>
                            <div class="card-body">
                                {{ $jml['gtk_all'] }}                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">  
                                <h4>Jumlah PPPK</h4>                 
                            </div>
                            <div class="card-body">
                               {{ $jml['pppk_all'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Guru Penggerak</h4>
                            </div>
                            <div class="card-body">
                               {{ $jml['penggerak'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Ruangan</h4>
                            </div>
                            <div class="card-body">
                               {{ $jml['ruangan_all'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-flag"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Seluruh Inovasi/Aksi Nyata</h4>
                            </div>
                            <div class="card-body">
                                {{ $data['all'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="far fa-smile"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Inovasi/Aksi Nyata Lolos</h4>
                            </div>
                            <div class="card-body">
                                {{ $data['terima'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-frown"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Inovasi/Aksi Nyata Tidak Lolos</h4>
                            </div>
                            <div class="card-body">
                                {{ $data['tolak'] }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Menunggu Penilaian</h4>
                            </div>
                            <div class="card-body">
                                {{ $data['waiting'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">

                    <div class="card">
                        <div class="card-header">
                            <h5>Data Praktik baik</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <label for="">Bidang Pengembangan</label>
                                    <select class="form-control select risk_value" id="bid_pengembangan">
                                        <option value="">-- Semua --</option>
                                        @foreach ($bid_pengembangan as $data)
                                            <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 5%">No</th>
                                            <th class="text-center">Judul</th>
                                            <th class="text-center">Deskripsi</th>
                                            <th class="text-center">Penulis</th>
                                            <th class="text-center">Bidang Pengembangan</th>
                                            <th class="text-center">Waktu Terbit</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- modal show inovasi --}}
    @foreach ($getData as $item)
    <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLongTitle">Detil Inovasi</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($item->image !== null)
                        <div class="article-header col-md-12">
                            <img src="{{ URL::to('/') }}/{{ $item->image }}" class="img-fluid center mx-auto d-block"
                                alt="Responsive image" style="height: 400px">
                        </div>
                    @endif
                    <table class="table">
                        <tr>
                            <td style="width: 15%" valign="top">Judul : </td>
                            <td valign="top" ><strong>{{ $item->judul }}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 15%" valign="top">Penulis : </td>
                            <td valign="top"><strong>{{ $item->owner->nama }}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 20%" valign="top">Bid Pengembangan : </td>
                            <td valign="top">
                                @foreach ($item->inovasibidangpengembangan as $inovasi)
                                    {{ $inovasi->bidangpengembangan->nama }},
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 20%" valign="top">Deskripsi : </td>
                            <td valign="top">{!! $item->deskripsi !!}</td>
                        </tr>
                        @if ($item->video !== NULL)
                        @php
                            $link = explode('=',$item->video);
                            if ($link  > 1) {
                                $link = end($link);                                
                            }
                           
                        @endphp
                        <tr>
                            <td style="width: 15%" valign="top">Video : </td>
                            <td valign="top">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/{{ $link }}"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </td>
                        </tr>        
                        @endif
                        <tr>
                            <td style="width: 15%" valign="top">Referensi/Jurnal : </td>
                            <td valign="top"><a href="{{ $item->link }}"> {{ $item->link }}</a></td>
                        </tr>
                        <tr>
                            <td style="width: 15%" valign="top">Dokumen Pendukung : </td>
                            <td valign="top">@if ($item->document)
                                <a href="{{ URL::to('') }}/{{ $item->document }}" target="_blank" class="btn btn-info btn-sm mb-2">File Penunjang : {{ $item->document }}</a>
                            @endif   </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
    {{-- modal show --}}
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
           var table = $('#example').DataTable({
                processing: true,
                serverSide: true, //aktifkan server-side 
                ajax: {
                    url: "{{ URL::to('get-praktik-baik') }}", // routing ke group.index
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-right'
                    },
                    {
                        data: 'judul',
                        name: 'judul',
                    },
                    {
                        data: 'deskripsi_readmore',
                        name: 'deskripsi_readmore',
                    },
                    {
                        data: 'owner.nama',
                        name: 'owner.nama',
                        className: 'text-center',
                    },
                    {
                        data: 'bidang_pengembangan',
                        name: 'bidang_pengembangan',
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [5, 'asc']
                ]
            });

            // DROPDOWN FILTER UNIT
            $('#bid_pengembangan').change(function() {
                var id = $(this).val();
                // console.log(id);
                table.column(4)
                    .search($(this).val())
                    .draw();
            });
        });

        $("#add-btn").click(function() {
            $("#tambah-edit-modal").modal('show');
            $("#modal-judul").html("Tambah Mata Pelajaran Baru");
        });

        // ** TAMBAH DATA BARU * //
        if ($("#form-tambah-edit").length > 0) {
            $("#form-tambah-edit").validate({
                submitHandler: function(form) {
                    var actionType = $('#tombol-simpan').val();
                    $('#tombol-simpan').html('Menyimpan . .');

                    $.ajax({
                        type: "POST",
                        url: "{{ URL::to('master/bidang-pengembangan/store') }}",
                        data: $('#form-tambah-edit').serializeArray(),
                        dataType: 'json',
                        success: function(data) {
                            $('#form-tambah-edit').trigger("reset");
                            $('#tambah-edit-modal').modal("hide");
                            $('#tombol-simpan').html('Simpan');
                            var oTable = $('#example').dataTable();
                            oTable.fnDraw(false);
                            iziToast.success({
                                title: 'Berhasil !',
                                message: "Data Mata Pelajaran " + data.nama +
                                    " berhasil disimpan.",
                                position: 'topRight'
                            });
                        },
                        error: function(data) {
                            console.log('Error', data);
                            $('#tombol-simpan').html('Simpan');
                        }
                    });
                }
            });
        }

        // ** EDIT DATA * // 
        $("body").on("click", ".edit", function() {
            var data_id = $(this).data('id');
            $.get("{{ URL::to('master/bidang-pengembangan/edit') }}/" + data_id, function(data) {
                $("#modal-judul").html("Edit Mata Pelajaran " + data.nama);
                $("tombol-simpan").val("edit-post");
                $("#tambah-edit-modal").modal('show');
                $("#id").val(data.id);
                $("#nama").val(data.nama);
                if (data.is_aktif === true) {
                    $('#is_aktif').prop('checked', true);
                } else {
                    $('#is_aktif').prop('checked', false);
                }
            });
        });

        $(document).on('click', ".delete", function() {
            var dataId = $(this).data('id');
            var dataName = $(this).data('name');
            console.log(dataId);
            swal({
                title: 'Apakah Anda Yakin?',
                text: 'Data akan dihapus',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((isConfirm) => {
                if (isConfirm) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ URL::to('master/bidang-pengembangan/delete') }}/" + dataId,
                        success: function(data) {
                            var oTable = $("#example").dataTable();
                            oTable.fnDraw(false);
                            iziToast.success({
                                title: 'Berhasil !',
                                message: "Data Mata Pelajaran " + dataName +
                                    " berhasil dihapus.",
                                position: 'topRight'
                            });
                        }
                    });
                } else {
                    iziToast.info({
                        title: 'Info',
                        message: 'Tidak ada perubahan yg disimpan.',
                        position: 'topRight'
                    });
                }
            });
        });
    </script>
@endpush
