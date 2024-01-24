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
                            <h6>Profil Sekolah</h6>
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td style="width: 30%">1. Nama Sekolah</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">2. NPSN</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->npsn }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">3. Jenjang Pendidikan</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->bentuk_pendidikan }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">4. Status Sekolah</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->status_sekolah }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">5. Alamat Sekolah</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;RT/RW</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->rt }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;KodePos</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->kodepos }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;Kelurahan</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_kelurahan }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;Kecamatan</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_kecamatan }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;Kabupaten/Kota</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_kabupaten }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;Provinsi</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_provinsi }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">&nbsp;&nbsp;&nbsp;&nbsp;Negara</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">6. Posisi Geeografis</td>
                                        <td style="width: 1%">:</td>
                                        <td>Long :
                                            <br>
                                            Lat : 
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
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">8. Tanggal SK Pendirian</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">9. Status Kepemilikan</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">10. SK Izin Operasional</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">11. Tgl SK Izin Operasional</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">12. Kebutuhan Khusus Dilayani</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">13. No Rekening</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">14. Nama Bank</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">15. Cabang KPC/Unit</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">16. Rekening Atas Nama</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">17. MBS</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">18. Memungut Iuran</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">19. Nominal/Siswa</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $siswa }} Siswa</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">20. Nama Wajib Pajak</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">21. NPWP</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                </table>
                            </div>
                            <h6>3. Kontak Sekolah</h6>
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td style="width: 30%">22. Nomor Telepon</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">23. Nomor Tax</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">24. Alamat Surel</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">25. <em>Website</em></td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                </table>
                            </div>
                            <h6>4. Data Periodik</h6>
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td style="width: 30%">26. Waktu Penyelenggaran</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">27. Bersedia Menerima BOS?</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">28. Sertifikat ISO</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">29. Sumber Listrik</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">30. Daya Listrik <em>(watt)</em></td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">31. Akses Internet</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">32. Akses Internet Alternatif</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">33. Semester/TA</td>
                                        <td style="width: 1%">:</td>
                                        <td>{{ $getData->induk_negara }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <a href="{{ URL::to('data-sekolah/edit-detail/'.Crypt::encrypt($getData->npsn)) }}" class="btn btn-primary pull-right float-right"><i class="fa fa-pencil-alt"></i> Ubah</a>
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
