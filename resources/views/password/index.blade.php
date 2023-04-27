@extends('layouts.main')

@section('title', 'Ganti Password')

@push('css-custom')
    <link rel="stylesheet" href="assets/modules/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="assets/modules/bootstrap-daterangepicker/daterangepicker.css">
@endpush

@section('container')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Ganti Password</h1>
            </div>
            @if (session()->has('wrong'))
                <div class="alert alert-danger d-flex justify-content-center" role="alert">
                    {{ session('wrong') }}
                  </div>
                @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <form action="/ganti-password/simpan" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ Crypt::encrypt($user->id) }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Kata Sandi Lama</label>
                                        <input type="password" name="oldpswd" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Kata Sandi Baru</label>
                                        <input type="password" name="newpswd" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label>Ulangi Kata Sandi Baru</label>
                                        <input type="password" name="newpswd2" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right" id="btn-submit">
                                    Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('js-custom')
    <script src="assets/js/page/forms-advanced-forms.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $('#btn-submit').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            swal({
                    title: 'Apakah Anda Yakin?',
                    text: 'Sandi Anda, akan dirubah.',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((isConfirm) => {
                    if (isConfirm) {
                        if (isConfirm) form.submit();
                    } else {
                        swal('Data tidak disimpan');
                    }
                });
        });
    </script>
@endpush
