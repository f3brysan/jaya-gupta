@extends('layouts.main')

@section('title', 'Data Aksi Nyata Praktik Baik')
@push('css-custom')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/izitoast/css/iziToast.min.css">
@endpush

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Aksi Nyata Praktik Baik</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab-center" data-toggle="tab" href="#home-center"
                                    aria-controls="home-center" role="tab" aria-selected="true">
                                    Belum dinilai
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="service-tab-center" data-toggle="tab" href="#service-center"
                                    aria-controls="service-center" role="tab" aria-selected="false">
                                    Sudah Dinilai
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home-center" aria-labelledby="home-tab-center" role="tabpanel">
                                <div class="card-body">


                                    <h6>Aksi Nyata Belum Dinilai</h6>
                                    <br>
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-hover table-bordered"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 5%">No</th>
                                                    <th class="text-center" style="width: 20%">Judul</th>
                                                    <th class="text-center" style="width: 20%">Deskripsi</th>
                                                    <th class="text-center" style="width: 10%">Gambar</th>
                                                    <th class="text-center" style="width: 10%">Pemilik</th>
                                                    <th class="text-center" style="width: 15%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($waiting as $item)
                                                    <tr>
                                                        <td align="right">{{ $loop->iteration }}</td>
                                                        <td align="center">{{ $item->judul }}</td>
                                                        <td align="center">{!! Str::words(strip_tags($item->deskripsi), 10) !!}</td>
                                                        <td align="center"> <img
                                                                src="{{ URL::to('/') }}/{{ $item->image }}"
                                                                style="width: 80px" class="img-fluid img-thumbnail"
                                                                alt=""></td>
                                                        <td align="center">
                                                            {{ $item->owner->nama ?? '' }}
                                                        </td>
                                                        <td align="center">
                                                            <div class="btn-group" role="group"
                                                                aria-label="Basic example">
                                                                <a href="javascript:void(0)" class="btn btn-info m-1"
                                                                    title="Lihat Data" data-toggle="modal"
                                                                    data-target="#modal{{ $item->id }}"><i
                                                                        class="far fa-eye"></i></a>
                                                                @php
                                                                    $encryptUrl = Crypt::encrypt($item->id);
                                                                @endphp
                                                                <form action="{{ URL::to('kurator/nilai') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $encryptUrl }}">
                                                                    <button type="submit" class="btn btn-success m-1"
                                                                        id="status-trm" title="Terima Inovasi"
                                                                        name="status" value="terima"><i
                                                                            class="fas fa-check"></i></button>
                                                                </form>
                                                                <button type="button" class="btn btn-danger m-1"
                                                                    title="Tolak Inovasi" value="tolak"
                                                                    onclick="tolak('{{ $encryptUrl }}','{{ $item->judul }}')"><i
                                                                        class="fas fa-times"></i></button>
                                                        </td>
                                    </div>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center" style="width: 5%">No</th>
                                            <th class="text-center" style="width: 20%">Judul</th>
                                            <th class="text-center" style="width: 20%">Deskripsi</th>
                                            <th class="text-center" style="width: 10%">Gambar</th>
                                            <th class="text-center" style="width: 10%">Pemilik</th>
                                            <th class="text-center" style="width: 15%">Aksi</th>
                                        </tr>
                                    </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="service-center" aria-labelledby="service-tab-center" role="tabpanel">
                            <div class="card-body">
                                <h6>Aksi Nyata Sudah Dinilai</h6>
                                <br>
                                <div class="table-responsive">
                                    <table id="example2" class="table table-bordered table-hover table-bordered"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 5%">No</th>
                                                <th class="text-center" style="width: 20%">Judul</th>
                                                <th class="text-center" style="width: 20%">Deskripsi</th>
                                                <th class="text-center" style="width: 10%">Gambar</th>
                                                <th class="text-center" style="width: 10%">Pemilik</th>
                                                <th class="text-center" style="width: 15%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($done as $item)
                                                <tr>
                                                    <td align="right">{{ $loop->iteration }}</td>
                                                    <td align="center">{{ $item->judul }}</td>
                                                    <td align="center">{!! Str::words(strip_tags($item->deskripsi), 10) !!}</td>
                                                    <td align="center"> <img
                                                            src="{{ URL::to('/') }}/{{ $item->image }}"
                                                            style="width: 80px" class="img-fluid img-thumbnail"
                                                            alt=""></td>
                                                    <td align="center">
                                                        {{ $item->owner->nama ?? '' }}
                                                    </td>
                                                    <td align="center">
                                                        @if ($item->nilai->status == 0)
                                                            <span class="badge badge-danger">Telah ditolak oleh :
                                                                {{ $item->nilai->owner->nama ?? '' }} <br> Pada :
                                                                {{ $item->nilai->created_at }}
                                                                <br>
                                                                Memo : {{ $item->nilai->memo }}
                                                            </span>
                                                            <br>
                                                        @else
                                                            <span class="badge badge-success">Telah disetujui oleh :
                                                                {{ $item->nilai->owner->nama }} <br> Pada :
                                                                {{ $item->nilai->created_at }}</span>
                                                            <br>
                                                        @endif

                                                        <div class="btn-group m-1" role="group"
                                                            aria-label="Basic example">
                                                            <a href="javascript:void(0)" class="btn btn-info m-1"
                                                                title="Lihat Data" data-toggle="modal"
                                                                data-target="#modal{{ $item->id }}"><i
                                                                    class="far fa-eye"></i></a>
                                                            @php
                                                                $encryptUrl = Crypt::encrypt($item->id);
                                                            @endphp
                                                            <form action="{{ URL::to('guru/aksi-nyata/ubah') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $encryptUrl }}">
                                                                @if ($item->nilai->status == 0)
                                                                    <button type="submit" class="btn btn-success m-1"
                                                                        title="Terima Inovasi" id="terima-btn"
                                                                        name="submit" value="terima"><i
                                                                            class="fas fa-check"></i></button>
                                                                @else
                                                                    <button type="submit" class="btn btn-danger m-1"
                                                                        title="Tolak Inovasi" id="tolak-btn"
                                                                        name="submit" value="tolak"><i
                                                                            class="fas fa-times"></i></button>
                                                                @endif


                                                            </form>
                                                    </td>
                                </div>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center" style="width: 20%">Judul</th>
                                        <th class="text-center" style="width: 20%">Deskripsi</th>
                                        <th class="text-center" style="width: 10%">Gambar</th>
                                        <th class="text-center" style="width: 10%">Pemilik</th>
                                        <th class="text-center" style="width: 15%">Aksi</th>
                                    </tr>
                                </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </div>
    </div>
    </section>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal-memo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Memo Kurator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ URL::to('kurator/nilai') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="status" value="tolak">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Memo</label>
                            <textarea class="form-control" id="memo" name="memo" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($all as $item)
        <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog-centered modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLongTitle">Detil Inovasi</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <tr>
                                <td style="width: 15%" valign="top">Judul : </td>
                                <td valign="top"><strong>{{ $item->judul }}</strong></td>
                            </tr>
                            <tr>
                                <td style="width: 20%" valign="top">Deskripsi : </td>
                                <td valign="top">{!! $item->deskripsi !!}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%" valign="top">Video : </td>
                                @if ($item->video !== null)
                                    @if (str_contains($item->video, 'www.youtube.com/watch?'))
                                        @php
                                            $link = explode('=', $item->video);
                                            if ($link > 1) {
                                                $link = end($link);
                                            }
                                        @endphp
                                        <td valign="top">
                                            <iframe width="560" height="315"
                                                src="https://www.youtube.com/embed/{{ $link }}"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                        </td>
                                    @else
                                        <td><strong>Link Video Salah</strong></td>
                                    @endif
                                @else
                                    <td>Tidak ada video pendukung.</td>
                                @endif
                            </tr>
                            <tr>
                                <td style="width: 15%" valign="top">Gambar : </td>
                                <td valign="top"><img src="{{ URL::to('/') }}/{{ $item->image }}" alt=""
                                        class="img-fluid img-thumbnail" style="height: 100px"></td>
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

@endsection
@push('js-custom')
    <!-- JS Libraies -->
    <script src="{{ URL::to('/') }}/assets/modules/datatables/datatables.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js">
    </script>
    <script src="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/izitoast/js/iziToast.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable();
            // $('#example2').DataTable();
        });

        $('.aksi-btn').on('click', function(e) {
            // console.log($(this).val());
            e.preventDefault();
            var form = $(this).parents('form');
            swal({
                    title: 'Apakah Anda Yakin?',
                    text: 'Data akan dihapus',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((isConfirm) => {
                    if (isConfirm) {
                        swal('Data Telah dihapus', {
                            icon: 'success',
                        });
                        console.log(form);
                        if (isConfirm) form.submit();
                    } else {
                        swal('Tidak Ada perubahan');
                    }
                });
        });
    </script>
    <script>
        function tolak(id, judul) {
            console.log(id);
            swal({
                    title: 'Apakah Anda Yakin?',
                    text: 'Rubrik ' + judul + ' ditolak',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((isConfirm) => {
                    if (isConfirm) {
                        $("#modal-memo").modal('show');
                        $("#id").val(id);
                    } else {
                        swal('Tidak Ada perubahan');
                    }
                });
        }
    </script>
    @if (session()->has('success'))
        <script>
            $(document).ready(function() {
                iziToast.success({
                    title: 'Berhasil !',
                    message: "{{ session('success') }}",
                    position: 'topRight'
                });
            });
        </script>
    @endif
@endpush
