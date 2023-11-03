@extends('layouts.main')

@section('title', 'Tambah Data Aksi Nyata')
@push('css-custom')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/summernote/summernote-bs4.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Aksi Nyata</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <form action="{{ URL::to('guru/aksi-nyata/store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Judul Aksi Nyata</label>
                                        <input type="text" name="judul" id="judul" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Deskripsi</label>
                                        <textarea class="summernote form-control" id="deskripsi" name="deskripsi"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>ID Video Youtube</label>
                                        <input type="text" name="video" id="video" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Gambar Pendukung</label>
                                    <input type="file" name="image" placeholder="Choose image" class="form-control" accept="image/*" id="image">                                      
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="">Preview</label>
                                    <br>
                                    <img id="preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                                        alt="preview image" style="max-height: 250px;">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="">Bidang Pengembangan</label>
                                    <select class="js-example-basic-multiple form-control" name="bidang_pengembangan[]"
                                    multiple="multiple" required>
                                    @foreach ($ms_bidang_pengembangan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right m-1" id="submit" name="submit"
                                    value="pub">Publikasi</button>
                                <button type="submit" class="btn btn-warning float-right m-1" id="submit" name="submit"
                                    value="save">Simpan Draft</button>
                                <a href="{{ URL::to('guru/aksi-nyata') }}" class="btn btn-secondary float-right m-1">Kembali</a>
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
            $('#image').change(function(){
           
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
   
@endpush
