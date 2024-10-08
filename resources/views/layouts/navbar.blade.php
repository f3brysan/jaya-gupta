<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ URL::to('') }}">Jaya Gupta</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ URL::to('') }}">JG</a>
        </div>
        <ul class="sidebar-menu">

            <li class="menu-header">Beranda</li>
            <li><a class="nav-link" href="{{ URL::to('') }}"><i class="fas fa-desktop"></i> <span>Beranda</span></a>
            </li>

            @role(['guru'])
                <li class="menu-header">Praktik Baik</li>
                <li><a class="nav-link" href="{{ URL::to('guru/inovasi') }}"><i class="fas fa-list"></i> <span>Data Inovasi
                            Praktik Baik</span></a></li>
                <li><a class="nav-link" href="{{ URL::to('guru/aksi-nyata') }}"><i class="fas fa-list"></i> <span>Data Aksi
                            Nyata Praktik Baik</span></a></li>
            @endrole

            @role(['kurator'])
                <li class="menu-header">Kurator</li>
                <li><a class="nav-link" href="{{ URL::to('kurator/inovasi') }}"><i class="fas fa-list"></i> <span>Data
                            Inovasi Praktik Baik</span></a></li>
                <li><a class="nav-link" href="{{ URL::to('kurator/aksi-nyata') }}"><i class="fas fa-list"></i> <span>Data
                            Aksi Nyata Praktik Baik</span></a></li>
            @endrole

            @role(['kepalasekolah', 'operator'])
                <li class="menu-header">Sekolah dan GTK</li>
                <li><a class="nav-link"
                        href="{{ URL::to('data-sekolah/show-detail/' . Crypt::encrypt(auth()->user()->bio->asal_satuan_pendidikan)) }}"><i
                            class="fas fa-list"></i> <span>Data
                            Sekolah</span></a></li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-list"></i>
                        <span>GTK</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ URL::to('data-guru') }}">Data Guru</a></li>
                        <li><a class="nav-link" href="{{ URL::to('data-tendik') }}">Data Tendik</a></li>
                        <li><a class="nav-link" href="{{ URL::to('data-gtk-nonaktif') }}">Guru Non Aktif</a>
                        </li>
                    </ul>
                </li>
                <li><a class="nav-link" href="{{ URL::to('data-peserta-didik') }}"><i class="fas fa-list"></i> <span>Data
                            Peserta Didik</span></a></li>
                <li><a class="nav-link" href="{{ URL::to('data-rombel') }}"><i class="fas fa-list"></i> <span>Data
                            Rombongan Belajar</span></a></li>
            @endrole

            @role(['superadmin', 'pimpinan'])
                <li class="menu-header">SI GTK</li>
                {{-- <li><a class="nav-link" href="{{ URL::to('data-guru') }}"><i class="fas fa-list"></i> <span>Profil
                    Guru/Admin</span></a></li> --}}
                <li><a class="nav-link" href="{{ URL::to('data-sekolah') }}"><i class="fas fa-list"></i> <span>Data
                            Sekolah</span></a></li>
                <li><a class="nav-link" href="{{ URL::to('admin/data-peserta-didik') }}"><i class="fas fa-list"></i>
                        <span>Data
                            Peserta Didik</span></a></li>
                <li><a class="nav-link" href="{{ URL::to('admin/data-rombel') }}"><i class="fas fa-list"></i> <span>Data
                            Rombel</span></a></li>
                <li><a class="nav-link" href="{{ URL::to('admin/data-guru') }}"><i class="fas fa-list"></i> <span>Data
                            Guru</span></a></li>
                <li><a class="nav-link" href="{{ URL::to('admin/data-tendik') }}"><i class="fas fa-list"></i> <span>Data
                            Tendik</span></a></li>
                <li><a class="nav-link" href="{{ URL::to('admin/data-gtk-nonaktif') }}"><i class="fas fa-list"></i>
                        <span>Data
                            GTK Non Aktif</span></a></li>
                {{-- <li><a class="nav-link" href="{{ URL::to('admin/data-pengawas') }}"><i class="fas fa-list"></i> <span>Data
                            Pengawas</span></a></li> --}}
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-list"></i>
                        <span>Rekapitulasi</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ URL::to('rekap/data-pensiun') }}">Perkiraan Pensiun</a></li>
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                                <span>Sebaran Guru</span></a>
                            <ul class="dropdown-menu">
                                {{-- <li><a class="nav-link" href="{{ URL::to('rekap/data-sebaran-guru/tk') }}">TK</a></li> --}}
                                <li><a class="nav-link" href="{{ URL::to('rekap/data-sebaran-guru/sd') }}">SD</a></li>
                                {{-- <li><a class="nav-link" href="{{ URL::to('rekap/data-sebaran-guru/smp') }}">SMP</a></li> --}}
                            </ul>
                        </li>
                        <li><a class="nav-link" href="{{ URL::to('rekap/data-sebaran-tendik') }}">Sebaran Tendik <i
                                    class="badge badge-danger float-right"><span class="fa fa-wrench"></span></i></a></li>
                        <li><a class="nav-link" href="{{ URL::to('rekap/data-guru-penggerak') }}">Guru Penggerak <i
                                    class="badge badge-danger float-right"><span class="fa fa-wrench"></span></i></a>
                        </li>
                    </ul>
                </li>                
            @endrole
            @role('superadmin')
                <li class="menu-header">Data Master</li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-list"></i>
                        <span>Master Data</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ URL::to('master/user') }}">Peran Pengguna</a></li>
                        <li><a class="nav-link" href="{{ URL::to('master/mata-pelajaran') }}">Mata Pelajaran</a></li>
                        {{-- <li><a class="nav-link" href="{{ URL::to('master/satuan-pendidikan') }}">Satuan Pendidikan</a></li> --}}
                        <li><a class="nav-link" href="{{ URL::to('master/bidang-pengembangan') }}">Bidang
                                Pengembangan</a>
                        </li>
                    </ul>
                </li>
            @endrole
        </ul>

        {{-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div> --}}
    </aside>
</div>
