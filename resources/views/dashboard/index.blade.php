@extends('layouts.main')

@section('title', 'Beranda')

@section('container')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Beranda</h1>
        </div>
        @if (auth()->user()->hasRole('guru'))
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-flag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Inovasi/Aksi Nyata</h4>
                        </div>
                        <div class="card-body">
                            {{ $data['all'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="far fa-smile"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Inovasi/Aksi Nyata Lolos</h4>
                        </div>
                        <div class="card-body">
                            {{ $data['terima'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-frown"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Inovasi/Aksi Nyata Tidak Lolos</h4>
                        </div>
                        <div class="card-body">
                            {{ $data['tolak'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Menunggu Penilaian</h4>
                        </div>
                        <div class="card-body">
                            {{ $data['waiting'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-flag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Seluruh Inovasi/Aksi Nyata</h4>
                        </div>
                        <div class="card-body">
                            {{ $data['all'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="far fa-smile"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Inovasi/Aksi Nyata Lolos</h4>
                        </div>
                        <div class="card-body">
                            {{ $data['terima'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-frown"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Inovasi/Aksi Nyata Tidak Lolos</h4>
                        </div>
                        <div class="card-body">
                            {{ $data['tolak'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Menunggu Penilaian</h4>
                        </div>
                        <div class="card-body">
                            {{ $data['waiting'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endif
       
    </section>
</div>
@endsection