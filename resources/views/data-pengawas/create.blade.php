@extends('layouts.main')

@section('title', 'Edit Data Tendik')
@push('css-custom')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ URL::to('/') }}/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/select2/dist/css/select2.min.css">
@endpush

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Pengawas</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Pemgawas</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ URL('admin/data-pengawas/store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <img id="preview-image-before-upload" src="{{ URL::to('/') }}"
                                                alt="preview image" style="max-height: 250px;">
                                        </div>
                                        <label class="mt-2">Foto Guru</label>
                                        <input type="file" name="image" placeholder="Choose image" id="image"
                                            accept="image/*" class="form-control @error('picture') is-invalid @enderror">
                                        @error('picture')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" name="nama_lengkap">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">NIP</label>
                                        <input type="text" name="nip" class="form-control" id=""
                                            onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Pangkat Golongan</label>
                                        <input type="text" name="golongan" class="form-control" id="" ">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <label for="">Tempat Lahir</label>
                                                                <input type="text" name="tempatlahir" class="form-control" id=""
                                                                    value="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <label for="">Tanggal Lahir</label>
                                                                <input type="date" name="tgllahir" class="form-control pensiun" id="tgllahir"
                                                                    value="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <label for="">Usia Pensiun</label>
                                                                <select name="usia_pensiun" class="form-control pensiun" id="usia_pensiun">
                                                                    <option value="0">-- Pilih Usia Pensiun --</option>
                                                                    <option value="60"> 60 Tahun</option>
                                                                    <option value="65"> 65 Tahun</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <label for="">Tanggal Pensiun</label>
                                                                <input type="date" name="jurusan" class="form-control" id="tanggal_pensiun" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <label for="">Jenis Sertifikasi</label>
                                                                <select name="sertifikasi" id="" class="form-control" required>
                                                                    <option value="">Pilih Sertfikasi</option>
                                                                    <option value="CAWAS">CAWAS</option>
                                                                    <option value="UJIKOM">UJIKOM</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <label for="">Kecamatan</label>
                                                                <select name="kecdom" id="kecdom" class="form-control">
                                                                    <option value="">Pilih Kecamatan</option>
                                                                       @foreach ($kecamatan
                                            as $kec)
                                        <option value="{{ $kec->name }}">{{ $kec->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Jenjang</label>
                                        <select class="form-control" name="periode_penugasan" id="periode_penugasan">
                                            <option value="">Pilih</option>
                                            <option value="TK">TK</option>
                                            <option value="SD">SD</option>
                                            <option value="SMP">SMP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Asal Sekolah</label>
                                        <select name="asal_satuan[]" class="form-control js-example-basic-multiple"
                                            multiple="multiple" id="">
                                            <option value="">-- Pilih Asal Sekolah --</option>
                                            @foreach ($sekolah as $item)
                                                <option value="{{ $item->npsn }}">{{ $item->npsn }} -
                                                    {{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
    <script src="{{ URL::to('/') }}/assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {

            $(document).ready(function() {
                $('.js-example-basic-multiple').select2({
                    theme: "classic",
                });
            });

            $('#image').change(function() {

                let reader = new FileReader();

                reader.onload = (e) => {

                    $('#preview-image-before-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);

            });
        });

        $(".pensiun").change(function() {
            var inputDate = $("#tgllahir").val();
            var pensiun = $("#usia_pensiun").val();

            var date = new Date(inputDate);
            date.setFullYear(date.getFullYear() + parseInt(pensiun));

            // Format the new date
            var formattedDate = date.toISOString().substring(0, 10); // Format as YYYY-MM-DD

            // Display the new date            
            $("#tanggal_pensiun").val(formattedDate);

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

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>
    <script>
        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.image-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(ofREvent) {
                imgPreview.src = ofREvent.target.result;
            }
        }
    </script>
@endpush
