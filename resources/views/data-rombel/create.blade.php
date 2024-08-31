@extends('layouts.main')

@section('title', 'Tambah Rombongan Belajar')
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
                <h1>Tambah Rombongan Belajar</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ URL::to('data-rombel/simpan') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nama Rombel <code>*</code></label>
                                        <select name="nama_rombel" class="form-select form-control" id="">
                                            <option value="">Pilih Rombel</option>
                                            @foreach ($rombelFromPesertaDidik as $item)
                                            <option value="{{ $item->rombel }}">{{ Str::upper($item->rombel) }}</option>
                                            @endforeach
                                        </select>                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Tingkat Kelas <code>*</code></label>
                                        <input type="text" class="form-control" name="tingkat_kelas">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Wali Kelas<code>*</code></label>
                                        <select name="wali_kelas" id="" class="form-control select2">
                                            <option value="">Pilih</option>
                                            @foreach ($guru as $item)
                                                <option value="{{ $item->bio->nuptk }}">{{ $item->bio->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Ruangan</label>
                                        <input type="text" class="form-control" name="ruangan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Kurikulum</label>
                                        <input type="text" class="form-control" name="kurikulum">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <a href="{{ URL::to('data-rombel') }}" class="btn btn-secondary m-1">Kembali</a>
                                        <button type="submit" class="btn btn-primary m-1">Simpan</button>
                                    </div>
                                </div>
                            </form>
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
    <script src="{{ URL::to('/') }}/assets/modules/izitoast/js/iziToast.min.js"></script>
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
