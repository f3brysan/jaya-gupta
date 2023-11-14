@extends('layouts.main')

@section('title', 'Data Detil Peserta Didik')
@push('css-custom')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/select2/dist/css/select2.min.css">
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
                <h1>Data Detil {{ $bio->nama }}</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-lg-12">
                                <form action="{{ URL::to('data-peserta-didik/simpan') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ Crypt::encrypt($bio->id) }}">
                                    <div class="form-group">
                                        <label>Nama Peserta Didik</label>
                                        <input type="text" name="nama" class="form-control"
                                            value="{{ $bio->nama }}">
                                    </div>
                                    <div class="form-group">
                                        <label>NIPD</label>
                                        <input type="text" name="nipd" class="form-control numbers"
                                            value="{{ $bio->nipd }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select name="jk" id="jk" class="form-control">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" {{ $bio->jk == 'L' ? 'selected' : '' }}>Laki - laki
                                            </option>
                                            <option value="P" {{ $bio->jk == 'P' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>NISN</label>
                                        <input type="text" name="nisn" class="form-control numbers"
                                            value="{{ $bio->nisn }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <input type="text" name="tempatlahir" class="form-control"
                                            value="{{ $bio->tempatlahir }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tgllahir" class="form-control"
                                            value="{{ $bio->tgllahir }}">
                                    </div>
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="text" name="nik" class="form-control numbers"
                                            value="{{ $bio->nik }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Agama</label>
                                        <input type="text" name="agama" id="agama" class="form-control"
                                            value="{{ $bio->agama }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control">{{ $bio->alamat }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>HP</label>
                                        <input type="text" name="hp" id="hp" class="form-control numbers"
                                            value="{{ $bio->hp }}">
                                    </div>
                                    <div class="form-group">
                                        <h6>Data Ayah</h6>
                                        <label>Nama</label>
                                        <input type="text" name="nama_ayah" id="nama_ayah" class="form-control mb-2"
                                            value="{{ $bio->nama_ayah }}">
                                        <label>Jenjang Pendidikan</label>
                                        <input type="text" name="pendidikan_ayah" id="pendidikan_ayah"
                                            class="form-control mb-2" value="{{ $bio->pendidikan_ayah }}">
                                        <label>Pekerjaan</label>
                                        <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah"
                                            class="form-control mb-2" value="{{ $bio->pekerjaan_ayah }}">
                                    </div>
                                    <div class="form-group">
                                        <h6>Data Ibu</h6>
                                        <label>Nama</label>
                                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control mb-2"
                                            value="{{ $bio->nama_ibu }}">
                                        <label>Jenjang Pendidikan</label>
                                        <input type="text" name="pendidikan_ibu" id="pendidikan_ibu"
                                            class="form-control mb-2" value="{{ $bio->pendidikan_ibu }}">
                                        <label>Pekerjaan</label>
                                        <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu"
                                            class="form-control mb-2" value="{{ $bio->pekerjaan_ibu }}">
                                    </div>
                                    <div class="form-group">
                                        <h6>Data Wali</h6>
                                        <label>Nama</label>
                                        <input type="text" name="nama_wali" id="nama_wali" class="form-control mb-2"
                                            value="{{ $bio->nama_wali }}">
                                        <label>Jenjang Pendidikan</label>
                                        <input type="text" name="pendidikan_wali" id="pendidikan_wali"
                                            class="form-control mb-2" value="{{ $bio->pendidikan_wali }}">
                                        <label>Pekerjaan</label>
                                        <input type="text" name="pekerjaan_wali" id="pekerjaan_wali"
                                            class="form-control mb-2" value="{{ $bio->pekerjaan_wali }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Rombel</label>
                                        <input type="text" name="rombel" id="rombel" class="form-control"
                                            value="{{ $bio->rombel }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Kebutuhan Khusus</label>
                                        <input type="text" name="kebutuhan_khusus" id="kebutuhan_khusus"
                                            class="form-control" value="{{ $bio->kebutuhan_khusus }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Sekolah Asal</label>
                                        <input type="text" name="sekolah_asal" id="sekolah_asal"
                                            class="form-control" value="{{ $bio->sekolah_asal }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Anak Ke</label>
                                        <input type="text" name="anak_ke" id="anak_ke"
                                            class="form-control numbers" value="{{ $bio->anak_ke }}">
                                    </div>
                                    <div class="form-group">
                                        <label>No KK</label>
                                        <input type="text" name="no_kk" id="no_kk"
                                            class="form-control numbers" value="{{ $bio->no_kk }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Berat Badan</label>
                                        <input type="text" name="bb" id="bb"
                                            class="form-control numbers" value="{{ $bio->bb }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Tinggi Badan</label>
                                        <input type="text" name="tb" id="tb"
                                            class="form-control numbers" value="{{ $bio->tb }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Lingkar Kepala</label>
                                        <input type="text" name="lingkar_kepala" id="lingkar_kepala"
                                            class="form-control numbers" value="{{ $bio->lingkar_kepala }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Jml Saudara Kandung</label>
                                        <input type="text" name="jml_saudara" id="jml_saudara"
                                            class="form-control numbers" value="{{ $bio->jml_saudara }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Jarak Rumah Ke Sekolah (Km)</label>
                                        <input type="text" name="jarak_sekolah" id="jarak_sekolah"
                                            class="form-control numbers" value="{{ $bio->jarak_sekolah }}">
                                    </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ URL::to('data-peserta-didik') }}" class="btn btn-secondary"><i class="fa fa-arrow-alt-circle-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                          </div>                                                              
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_unggah_excel" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Unggah Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ URL::to('data-peserta-didik/import') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>File Excel</label>
                                <input type="file" name="dokumen" placeholder="Unggah data excel"
                                    class="form-control"
                                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                    id="dokumen">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
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
        <script src="{{ URL::to('/') }}/assets/modules/select2/dist/js/select2.full.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    "autoWidth": false,
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
        <script>
            $('.numbers').keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });
        </script>
    @endpush
