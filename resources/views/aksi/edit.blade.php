@extends('layouts.main')

@section('title', 'Ubah Data Aksi Nyata')
@push('css-custom')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/modules/summernote/summernote-bs4.css">
@endpush

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Ubah Data Aksi Nyata</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <form action="{{ URL::to('guru/aksi-nyata/store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $inovasi->id }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Judul Inovasi</label>
                                        <input type="text" name="judul" id="judul" class="form-control" value="{{ $inovasi->judul }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Deskripsi</label>
                                        <textarea class="summernote form-control" id="deskripsi" name="deskripsi">{{ $inovasi->deskripsi }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Link Video Youtube</label>
                                        <input type="text" name="video" id="video" class="form-control" value="{{ $inovasi->video }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                    <input type="file" name="image" placeholder="Choose image" id="image">                                     
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="">Preview</label>
                                    <br>
                                    <img id="preview-image-before-upload" src="{{  URL::to('/') }}/{{ $inovasi->image }}"
                                        alt="preview image" style="max-height: 250px;">
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
    <script>
        $(document).ready(function() {
            $('#image').change(function(){
           
           let reader = new FileReader();
       
           reader.onload = (e) => { 
       
             $('#preview-image-before-upload').attr('src', e.target.result); 
           }
       
           reader.readAsDataURL(this.files[0]); 
         
          });
        });
    </script>
    <script>
        function previewImage(){
           const image = document.querySelector('#image');
           const imgPreview = document.querySelector('.image-preview'); 

           imgPreview.style.display= 'block';

           const oFReader = new FileReader();
           oFReader.readAsDataURL(image.files[0]);
           oFReader.onload = function(ofREvent){
            imgPreview.src = ofREvent.target.result;
           }
        }
    </script>    
@endpush
