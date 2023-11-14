@extends('layouts.main')

@section('title', 'Data GTK Non Aktif')
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
                <h1>Data GTK Non Aktif</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="col-md-12">                           
                            <div class="col-lg-12 table-responsive">
                                <table id="example" class="table table-bordered table-hover table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Aksi</th>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">NUPTK</th>
                                            <th class="text-center">JK</th>
                                            <th class="text-center">Tempat Lahir</th>
                                            <th class="text-center">Tanggal Lahir</th>
                                            <th class="text-center">NIP</th>
                                            <th class="text-center">Status Kepegawaian</th>
                                            <th class="text-center">Mengajar</th>
                                            <th class="text-center">Gelar Depan</th>
                                            <th class="text-center">Gelar Belakang</th>
                                            <th class="text-center">Jenjang</th>
                                            <th class="text-center">Jurusan/Prodi</th>
                                            <th class="text-center">Sertifikasi</th>
                                            <th class="text-center">Nama Dusun</th>
                                            <th class="text-center">Desa/Kelurahan</th>
                                            <th class="text-center">Kecamatan</th>
                                            <th class="text-center">Kodepos</th>
                                            <th class="text-center">Telepon</th>
                                            <th class="text-center">HP</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Tugas Tambahan</th>
                                            <th class="text-center">SK CPNS</th>
                                            <th class="text-center">Tanggal CPNS</th>
                                            <th class="text-center">SK Pengangkatan</th>
                                            <th class="text-center">TMT Pengangkatan</th>
                                            <th class="text-center">Lembaga Pengangkatan</th>
                                            <th class="text-center">Pangkat Golongan</th>
                                            <th class="text-center">Sumber Gaji</th>
                                            <th class="text-center">Nama Ibu Kandung</th>
                                            <th class="text-center">Status Perkawinan</th>
                                            <th class="text-center">Nama Suami/Istri</th>
                                            <th class="text-center">Pekerjaan Suami/Istri</th>
                                            <th class="text-center">TMT PNS</th>
                                            <th class="text-center">NPWP</th>
                                            <th class="text-center">Bank</th>
                                            <th class="text-center">No Rekening</th>
                                            <th class="text-center">Rekening Atas Nama</th>
                                            <th class="text-center">NIK</th>
                                            <th class="text-center">No KK</th>
                                            <th class="text-center">Guru Penggerak</th>
                                            <th class="text-center">Tugas Tambahan</th>
                                            <th class="text-center">JJM</th>
                                            <th class="text-center">Total JJM</th>
                                            <th class="text-center">Siswa</th>
                                            <th class="text-center">Status Sekolah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getData as $dt)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="{{ URL::to('data-guru/ubah/' . $dt->id) }}"
                                                        target="_blank" title="Ubah Data" class="btn btn-sm btn-info m-1 disabled"><i
                                                            class="fa fa-edit"></i></a>                                                   
                                                </td>
                                                <td class="text-right">{{ $loop->iteration }}</td>
                                                <td>{{ $dt->nama }}</td>
                                                <td>{{ $dt->nuptk }}</td>
                                                <td>{{ $dt->gender }}</td>
                                                <td>{{ $dt->tempatlahir }}</td>
                                                <td>{{ $dt->tanggallahir }}</td>
                                                <td>{{ $dt->nip }}</td>
                                                <td>{{ $dt->status_kepegawaian }}</td>
                                                <td>{{ $dt->mengajar }}</td>
                                                <td>{{ $dt->gelar_depan }}</td>
                                                <td>{{ $dt->gelar_belakang }}</td>
                                                <td>{{ $dt->pendidikan_terakhir }}</td>
                                                <td>{{ $dt->prodi }}</td>
                                                <td>{{ $dt->sertifikasi }}</td>
                                                <td>{{ $dt->alamat }}</td>
                                                <td>{{ $dt->keldom }}</td>
                                                <td>{{ $dt->kecdom }}</td>
                                                <td>{{ $dt->kodepos }}</td>
                                                <td>{{ $dt->telepon }}</td>
                                                <td>{{ $dt->wa }}</td>
                                                <td>{{ $dt->user->email }}</td>
                                                <td>{{ $dt->tugas_tambahan }}</td>
                                                <td>{{ $dt->sk_cpns }}</td>
                                                <td>{{ $dt->tgl_cpns }}</td>
                                                <td>{{ $dt->sk_pengangkatan }}</td>
                                                <td>{{ $dt->tmt_pengangkatan }}</td>
                                                <td>{{ $dt->lembaga_pengangkatan }}</td>
                                                <td>{{ $dt->golongan }}</td>
                                                <td>{{ $dt->sumber_gaji }}</td>
                                                <td>{{ $dt->nm_ibu }}</td>
                                                <td>{{ $dt->status_perkawinan }}</td>
                                                <td>{{ $dt->nm_pasangan }}</td>
                                                <td>{{ $dt->pekerjaan_pasangan }}</td>
                                                <td>{{ $dt->tmt_pns }}</td>
                                                <td>{{ $dt->npwp }}</td>
                                                <td>{{ $dt->bank }}</td>
                                                <td>{{ $dt->norek_bank }}</td>
                                                <td>{{ $dt->nama_norek }}</td>
                                                <td>{{ $dt->nik }}</td>
                                                <td>{{ $dt->no_kk }}</td>
                                                <td>{{ $dt->is_penggerak }}</td>
                                                <td>{{ $dt->jam_tgs_tambahan }}</td>
                                                <td>{{ $dt->jjm }}</td>
                                                <td>{{ $dt->jam_tgs_tambahan + $dt->jjm }}</td>
                                                <td>{{ $dt->siswa }}</td>
                                                <td>{{ $dt->status_sekolah }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                    <form action="{{ URL::to('data-guru/import') }}" method="post"
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

    <script>
        function importExcel() {
            $("#modal_unggah_excel").modal('show');
        }
    </script>
@endpush
