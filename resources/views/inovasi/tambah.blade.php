@extends('layouts.main')

@section('title', 'Tambah Data Inovasi')
@push('css-custom')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/summernote/summernote-bs4.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Inovasi</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <form action="{{ URL::to('guru/inovasi/store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Judul Inovasi</label>
                                        <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Deskripsi</label>
                                        <textarea class="summernote form-control" id="deskripsi" name="deskripsi"> {{ old('deskripsi') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Link Pendukung</label>
                                        <input type="text" name="link" id="link" class="form-control"
                                            value="{{ old('link') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Link Video Youtube</label>
                                        <input type="text" name="video" id="video" class="form-control" value="{{ old('video') }}" placeholder="Contoh : https://www.youtube.com/watch?v=Wi15J1p-LD8">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Dokumen Penunjang</label>  
                                        <p><code>File berekstensi *pdf dan berukuran dibawah 5Mb</code></p>                                      
                                        <input type="file" name="document" accept="application/pdf"
                                            placeholder="Choose document" id="document"
                                            class="form-control @error('document') is-invalid @enderror">                                           
                                        @error('document')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="">Gambar Penunjang</label>
                                        <p class="text-muted"><code>File berekstensi *jpg dan berukuran dibawah 5Mb</code></p>
                                        <input type="file" name="image" placeholder="Choose image" id="image"
                                            accept="image/*" class="form-control @error('picture') is-invalid @enderror">                                            
                                            @error('picture')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="">Preview</label>
                                        <br>
                                        <img id="preview-image-before-upload"
                                            src="https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg"
                                            alt="preview image" style="max-height: 250px;">
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Bidang Pengembangan</label>
                                            <select class="js-example-basic-multiple form-control"
                                                name="bidang_pengembangan[]" multiple="multiple" required>
                                                @foreach ($ms_bidang_pengembangan as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-right m-1" id="submit"
                                        name="submit" value="pub">Publikasi</button>
                                    <button type="submit" class="btn btn-warning float-right m-1" id="submit"
                                        name="submit" value="save">Simpan Draft</button>
                                    <a href="{{ URL::to('guru/inovasi') }}"
                                        class="btn btn-secondary float-right m-1">Kembali</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
@push('js-custom')
    <!-- JS Libraies -->
    <script src="{{ URL::to('/') }}/assets/modules/summernote/summernote-bs4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#image').change(function() {

                let reader = new FileReader();

                reader.onload = (e) => {

                    $('#preview-image-before-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);

            });

            $(document).ready(function() {
                $('.js-example-basic-multiple').select2({
                    theme: "classic",
                });
            });
        });
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


    @if ($errors->any())
        <script>
            $(document).ready(function() {
                @foreach ($errors->all() as $error)
                    iziToast.danger({
                        title: 'Warning !',
                        message: "{{ $error }}",
                        position: 'topRight'
                    });
                @endforeach
            });
        </script>
    @endif
@endpush
