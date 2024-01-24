@extends('layouts.main')

@section('title', 'Data Sekolah')
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
                <h1>Data Sekolah {{ $getData->nama }}</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5> {{ $getData->npsn }} - {{ $getData->nama }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ URL('data-sekolah/update-detail') }}" method="POST">
                                @csrf
                            <h6>Profil Sekolah</h6>
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td style="width: 30%">1. Nama Sekolah</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" value="{{ $getData->nama }}"
                                                readonly></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">2. NPSN</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="npsn" value="{{ $getData->npsn }}"
                                                readonly></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">3. Jenjang Pendidikan</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control"
                                                value="{{ $getData->bentuk_pendidikan }}" readonly></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">4. Status Sekolah</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control"
                                                value="{{ $getData->status_sekolah }}" readonly></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">5. Alamat Sekolah</td>
                                        <td style="width: 1%">:</td>
                                        <td>
                                            <textarea name="alamat" cols="30" rows="10" class="form-control" style="width: 100%">{{ $getData->alamat }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;RT/RW</td>
                                        <td style="width: 1%">:</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="rt"
                                                        value="{{ $getData->rt }}" placeholder="RT">
                                                </div>/
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="rw"
                                                        value="{{ $getData->rw }}" placeholder="RW">
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;KodePos</td>
                                        <td style="width: 1%">:</td>
                                        <td> <input type="text" class="form-control" name="kodepos"
                                                value="{{ $getData->kodepos }}" placeholder="Kodepos"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;Kelurahan</td>
                                        <td style="width: 1%">:</td>
                                        <td> <input type="text" class="form-control" name="induk_kelurahan"
                                                value="{{ $getData->induk_kelurahan }}" placeholder="Kelurahan"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;Kecamatan</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control"
                                                value="{{ $getData->induk_kecamatan }}" placeholder="Kecamatan" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;Kabupaten/Kota</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control"
                                                value="{{ $getData->induk_kabupaten }}" placeholder="Kabupaten" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;Provinsi</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control"
                                                value="{{ $getData->induk_provinsi }}" placeholder="Provinsi" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;Negara</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" value="Indonesia"
                                                placeholder="Negara" readonly></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">6. Posisi Geeografis</td>
                                        <td style="width: 1%">:</td>
                                        <td>Long : <input type="text" class="form-control" name="long"
                                                value="{{ $getData->long }}" placeholder="Long">
                                            <br>
                                            Lat : <input type="text" class="form-control" name="lat"
                                                value="{{ $getData->lat }}" placeholder="Lat">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <h6>2. Data Pelengkap</h6>
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td style="width: 30%">7. SK Pendirian Sekolah</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="sk_pendirian_sekolah"
                                                value="{{ $getData->sk_pendirian_sekolah }}"
                                                placeholder="SK Pendirian Sekolah"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">8. Tanggal SK Pendirian</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="tgl_sk_pendirian"
                                                value="{{ $getData->tgl_sk_pendirian }}" placeholder="Tgl SK Pendirian">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">9. Status Kepemilikan</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="status_kepemilikan"
                                                value="{{ $getData->status_kepemilikan }}"
                                                placeholder="Status Kepemilikan"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">10. SK Izin Operasional</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="sk_izin_operasional"
                                                value="{{ $getData->sk_izin_operasional }}"
                                                placeholder="SK Izin Operasional"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">11. Tgl SK Izin Operasional</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="tgl_sk_izin_operasional"
                                                value="{{ $getData->tgl_sk_izin_operasional }}"
                                                placeholder="Tgl. SK Izin Operasional"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">12. Kebutuhan Khusus Dilayani</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="kebutuhan_khusus"
                                                value="{{ $getData->kebutuhan_khusus }}" placeholder="Kebutuhan Khusus">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">13. No Rekening</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="norek"
                                                value="{{ $getData->norek }}" placeholder="No Rekening"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">14. Nama Bank</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="nama_bank"
                                                value="{{ $getData->nama_bank }}" placeholder="Nama Bank"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">15. Cabang KPC/Unit</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="kcp_bank"
                                                value="{{ $getData->kcp_bank }}" placeholder="KCP Bank"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">16. Rekening Atas Nama</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="nama_norek"
                                                value="{{ $getData->nama_norek }}" placeholder="Rekening Atas Nama"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">17. MBS</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="mbs"
                                                value="{{ $getData->mbs }}" placeholder="MBS"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">18. Memungut Iuran</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="iuran"
                                                value="{{ $getData->iuran }}" placeholder="Iuran"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">19. Nominal/Siswa</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control text-right" value="{{ $siswa }}" readonly></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">20. Nama Wajib Pajak</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="nama_npwp"
                                                value="{{ $getData->nama_npwp }}" placeholder="Nama NPWP"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">21. NPWP</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="no_npwp"
                                                value="{{ $getData->no_npwp }}" placeholder="No. NPWP"></td>
                                    </tr>
                                </table>
                            </div>
                            <h6>3. Kontak Sekolah</h6>
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td style="width: 30%">22. Nomor Telepon</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="notelp"
                                                value="{{ $getData->notelp }}" placeholder="No Telp"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">23. Nomor Tax</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="notax"
                                                value="{{ $getData->notax }}" placeholder="No Tax"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">24. Alamat Surel</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="email"
                                                value="{{ $getData->email }}" placeholder="Email"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">25. <em>Website</em></td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="website"
                                                value="{{ $getData->website }}" placeholder="Website"></td>
                                    </tr>
                                </table>
                            </div>
                            <h6>4. Data Periodik</h6>
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td style="width: 30%">26. Waktu Penyelenggaran</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="waktu_penyelenggaraan"
                                                value="{{ $getData->waktu_penyelenggaraan }}" placeholder="Waktu"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">27. Bersedia Menerima BOS?</td>
                                        <td style="width: 1%">:</td>
                                        <td><select class="form-control" name="is_bos" id="">
                                                @if ($getData->is_bos == 1)
                                                    <option value="1" selected> Iya</option>
                                                    <option value="0"> Tidak</option>
                                                @else
                                                    <option value="1"> Iya</option>
                                                    <option value="0" selected> Tidak</option>
                                                @endif
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">28. Sertifikat ISO</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="sertifikat_iso"
                                                value="{{ $getData->sertifikat_iso }}" placeholder="Sertifikat ISO"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">29. Sumber Listrik</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="sumber_listrik"
                                                value="{{ $getData->sumber_listrik }}" placeholder="Sumber Listrik"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">30. Daya Listrik <em>(watt)</em></td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="daya_listrik"
                                                value="{{ $getData->daya_listrik }}" placeholder="Daya Listrik"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">31. Akses Internet</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="akses_internet"
                                                value="{{ $getData->akses_internet }}"
                                                placeholder="Kecepatan Akses Internet"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">32. Akses Internet Alternatif</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="alternatif_internet"
                                                value="{{ $getData->alternatif_internet }}" placeholder="Alternatif">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">33. Semester/TA</td>
                                        <td style="width: 1%">:</td>
                                        <td><input type="text" class="form-control" name="semester_ta"
                                                value="{{ $getData->semester_ta }}" placeholder="Semester"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info pull-right float-right"><i
                                        class="fa fa-save"></i>
                                    Simpan</button>
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
    <script src="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js">
    </script>
    <script src="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {

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
