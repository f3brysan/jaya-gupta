@extends('layouts.main')

@section('title', 'Data Inovasi Praktik Baik')
@push('css-custom')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <style>
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;            
        }
    </style>
@endpush

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Inovasi Praktik Baik</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="float-right">
                            <a href="{{ URL::to('guru/inovasi/tambah') }}" class="btn btn-primary mb-3"> Tambah</a>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-hover table-bordered"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Judul</th>
                                        <th class="text-center">Deskripsi</th>
                                        <th class="text-center">Gambar</th>
                                        <th class="text-center">Bidang Pengembangan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Hasil</th>
                                        <th class="text-center" style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inovasi as $item)
                                        <tr>
                                            <td align="right">{{ $loop->iteration }}</td>
                                            <td align="center">{{ $item->judul }}</td>
                                            <td align="center">{!! Str::words($item->deskripsi, 10) !!}</td>
                                            <td align="center"> <img src="{{ URL::to('/') }}/{{ $item->image }}"
                                                    style="width: 80px" class="img-fluid img-thumbnail" alt=""></td>
                                            <td class="text-left">
                                                @foreach ($item->inovasibidangpengembangan as $item_inovasi)
                                                    <li>{{ $item_inovasi->bidangpengembangan->nama }}</li>
                                                @endforeach
                                            </td>
                                            <td align="center">
                                                @switch($item->status)
                                                    @case(0)
                                                        <span class="badge badge-warning">Draft</span>
                                                    @break

                                                    @case(1)
                                                        <span class="badge badge-success">Publish</span>
                                                    @break

                                                    @default
                                                        <span class="badge badge-danger">Tidak Diketahui</span>
                                                @endswitch
                                            </td>
                                            <td align="center">
                                                @if ($item->nilai == null)
                                                    <span class="badge badge-warning">Belum dinilai
                                                    </span>
                                                    <br>
                                                @else
                                                    @if ($item->nilai->status == 0)
                                                        <span class="badge badge-info">Memo :
                                                            {{ $item->nilai->memo }}</span>
                                                        <br>
                                                        <br>
                                                        <span class="badge badge-danger">Telah ditolak oleh :
                                                            {{ $item->nilai->owner->nama }} <br> Pada :
                                                            {{ $item->nilai->created_at }}</span>
                                                    @else
                                                        <span class="badge badge-success">Telah disetujui oleh :
                                                            {{ $item->nilai->owner->nama }} <br> Pada :
                                                            {{ $item->nilai->created_at }}</span>
                                                        <br>
                                                    @endif
                                                @endif
                                            </td>
                                            <td align="center">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="javascript:void(0)" class="btn btn-info m-1" title="Lihat Data"
                                                        data-toggle="modal" data-target="#modal{{ $item->id }}"><i
                                                            class="far fa-eye"></i></a>
                                                    @php
                                                        $encryptUrl = Crypt::encrypt($item->id);
                                                        if ($item->nilai != null) {
                                                            if ($item->nilai->status == 1) {
                                                                $disabled = 'disabled';
                                                            } else {
                                                                $disabled = '';
                                                            }
                                                        } else {
                                                            $disabled = '';
                                                        }
                                                        
                                                    @endphp
                                                    <a href="{{ URL::to('guru/inovasi/edit') . '/' . $encryptUrl }}"
                                                        class="btn btn-primary m-1 {{ $disabled }}"
                                                        title="Edit Data"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ URL::to('guru/inovasi/hapus') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" id="id"
                                                            value="{{ $encryptUrl }}">
                                                        <button type="submit" class="btn btn-danger m-1 hapus-btn"
                                                            {{ $disabled }} title="Hapus Data"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                            </td>
                        </div>

                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Judul</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">Gambar</th>
                                <th class="text-center">Bidang Pengembangan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Hasil</th>
                                <th class="text-center" style="width: 10%">Aksi</th>
                            </tr>
                        </tfoot>
                        </table>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>

    <!-- Modal -->
    @foreach ($inovasi as $item)
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
                            <div class="article-header">
                                <img src="{{ URL::to('/') }}/{{ $item->image }}" class="img-fluid center"
                                    alt="Responsive image" style="height: 400px">
                            </div>
                        @endif
                        <table class="table">
                            <tr>
                                <td style="width: 15%" valign="top">Judul : </td>
                                <td valign="top"><strong>{{ $item->judul }}</strong></td>
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
                            <tr>
                                <td style="width: 15%" valign="top">Video : </td>
                                <td valign="top">
                                    <iframe width="560" height="315"
                                        src="https://www.youtube.com/embed/{{ $item->video }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                </td>
                            </tr>        
                            @endif
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

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
