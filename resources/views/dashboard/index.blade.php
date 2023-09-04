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
        <section class="section">

        </section>

        <section class="section">
            <div class="section-header">

            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-bullhorn"></i> Informasi</h4>
                        </div>
                        <div class="card-body">
                            <div id="accordion">
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-1">
                                        <h4>Petunjuk Teknis Inovasi Praktik Baik</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion">
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                            eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                    </div>
                                </div>
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-2">
                                        <h4>Petunjuk Teknis Aksi Nyata Praktik Baik</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-2" data-parent="#accordion">
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                            eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                    </div>
                                </div>
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-3">
                                        <h4>Persyaratan Kurasi</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-3" data-parent="#accordion">
                                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                            eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>

    </div>
    </section>
    </div>
@endsection
