@extends('layouts.main')

@section('title', 'Data Peserta Didik')
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
                <h1>Data Peserta Didik</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">                            
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover table-bordered">
                                    <thead>
                                        <tr>                                            
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'No'}">
                                                <div>No</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1" style="width: 200px">
                                                Nama Siswa
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'NIPD'}" data-sheets-numberformat="{'1':1}">
                                                <div>NIPD</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'JK'}" data-sheets-numberformat="{'1':1}">
                                                <div>JK</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'NISN'}" data-sheets-numberformat="{'1':1}">
                                                <div>NISN</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Tempat Lahir'}"
                                                data-sheets-numberformat="{'1':1}">
                                                <div>Tempat Lahir</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Tanggal Lahir'}"
                                                data-sheets-numberformat="{'1':1}">
                                                <div>Tanggal Lahir</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'NIK'}"
                                                data-sheets-numberformat="{'1':2,'2':'0','3':1}">
                                                <div>NIK</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Agama'}" data-sheets-numberformat="{'1':1}">
                                                <div>Agama</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Alamat'}" data-sheets-numberformat="{'1':1}">
                                                <div>Alamat</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'HP'}" data-sheets-numberformat="{'1':1}">
                                                <div>HP</div>
                                            </th>
                                            <th class="text-center" rowspan="1" colspan="3"
                                                data-sheets-value="{'1':2,'2':'Data Ayah'}"
                                                data-sheets-numberformat="{'1':1}">Data Ayah</th>
                                            <th class="text-center" rowspan="1" colspan="3"
                                                data-sheets-value="{'1':2,'2':'Data Ibu'}"
                                                data-sheets-numberformat="{'1':1}">Data Ibu</th>
                                            <th class="text-center" rowspan="1" colspan="3"
                                                data-sheets-value="{'1':2,'2':'Data Wali'}"
                                                data-sheets-numberformat="{'1':1}">Data Wali</th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Rombel Saat Ini'}"
                                                data-sheets-numberformat="{'1':1}">
                                                <div>Rombel Saat Ini</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Kebutuhan Khusus'}">
                                                <div>Kebutuhan Khusus</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Sekolah Asal'}">
                                                <div>Sekolah Asal</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Anak ke-berapa'}">
                                                <div>Anak ke-berapa</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'No KK'}"
                                                data-sheets-numberformat="{'1':2,'2':'0','3':1}">
                                                <div>No KK</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Berat Badan'}">
                                                <div>Berat Badan</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Tinggi Badan'}">
                                                <div>Tinggi Badan</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Lingkar Kepala'}">
                                                <div>Lingkar Kepala</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Jml. Saudara\nKandung'}">
                                                <div>Jml. Saudara<br />
                                                    Kandung</div>
                                            </th>
                                            <th class="text-center" rowspan="2" colspan="1"
                                                data-sheets-value="{'1':2,'2':'Jarak Rumah\nke Sekolah (KM)'}">
                                                <div>Jarak Rumah<br />
                                                    ke Sekolah (KM)</div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" data-sheets-value="{'1':2,'2':'Nama'}"
                                                data-sheets-numberformat="{'1':1}">Nama</th>
                                            <th class="text-center" data-sheets-value="{'1':2,'2':'Jenjang Pendidikan'}"
                                                data-sheets-numberformat="{'1':1}">Jenjang Pendidikan</th>
                                            <th class="text-center" data-sheets-value="{'1':2,'2':'Pekerjaan'}"
                                                data-sheets-numberformat="{'1':1}">Pekerjaan</th>
                                            <th class="text-center" data-sheets-value="{'1':2,'2':'Nama'}"
                                                data-sheets-numberformat="{'1':1}">Nama</th>
                                            <th class="text-center" data-sheets-value="{'1':2,'2':'Jenjang Pendidikan'}"
                                                data-sheets-numberformat="{'1':1}">Jenjang Pendidikan</th>
                                            <th class="text-center" data-sheets-value="{'1':2,'2':'Pekerjaan'}"
                                                data-sheets-numberformat="{'1':1}">Pekerjaan</th>
                                            <th class="text-center" data-sheets-value="{'1':2,'2':'Nama'}"
                                                data-sheets-numberformat="{'1':1}">Nama</th>
                                            <th class="text-center" data-sheets-value="{'1':2,'2':'Jenjang Pendidikan'}"
                                                data-sheets-numberformat="{'1':1}">Jenjang Pendidikan</th>
                                            <th class="text-center" data-sheets-value="{'1':2,'2':'Pekerjaan'}"
                                                data-sheets-numberformat="{'1':1}">Pekerjaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_peserta_didik as $pd)
                                            <tr>                                                
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $pd->nama }}</td>
                                                <td>{{ $pd->nipd }}</td>
                                                <td>{{ $pd->jk }}</td>
                                                <td>{{ $pd->nisn }}</td>
                                                <td>{{ $pd->tempatlahir }}</td>
                                                <td>{{ $pd->tgllahir }}</td>
                                                <td>{{ $pd->nik }}</td>
                                                <td>{{ $pd->agama }}</td>
                                                <td>{{ $pd->alamat }}</td>
                                                <td>{{ $pd->hp }}</td>
                                                <td>{{ $pd->nama_ayah }}</td>
                                                <td>{{ $pd->pendidikan_ayah }}</td>
                                                <td>{{ $pd->pekerjaan_ayah }}</td>
                                                <td>{{ $pd->nama_ibu }}</td>
                                                <td>{{ $pd->pendidikan_ibu }}</td>
                                                <td>{{ $pd->pekerjaan_ibu }}</td>
                                                <td>{{ $pd->nama_wali }}</td>
                                                <td>{{ $pd->pendidikan_wali }}</td>
                                                <td>{{ $pd->pekerjaan_wali }}</td>
                                                <td>{{ $pd->rombel }}</td>
                                                <td>{{ $pd->kebutuhan_khusus }}</td>
                                                <td>{{ $pd->sekolah_asal }}</td>
                                                <td>{{ $pd->anak_ke }}</td>
                                                <td>{{ $pd->kk }}</td>
                                                <td>{{ $pd->bb }}</td>
                                                <td>{{ $pd->tb }}</td>
                                                <td>{{ $pd->lingkar_kepala }}</td>
                                                <td>{{ $pd->jml_saudara }}</td>
                                                <td>{{ $pd->jarak_sekolah }}</td>
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
            function importExcel() {
                $("#modal_unggah_excel").modal('show');
            }
        </script>
    @endpush
