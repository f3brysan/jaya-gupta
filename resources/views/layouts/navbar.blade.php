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
            <li><a class="nav-link" href="{{ URL::to('') }}"><i class="fas fa-desktop"></i> <span>Beranda</span></a></li>

           @role(['superadmin','guru'])
            <li class="menu-header">Praktik Baik</li>
            <li><a class="nav-link" href="{{ URL::to('guru/inovasi') }}"><i class="fas fa-list"></i> <span>Data Inovasi Praktik Baik</span></a></li>    
            <li><a class="nav-link" href="{{ URL::to('guru/aksi-nyata') }}"><i class="fas fa-list"></i> <span>Data Aksi Nyata Praktik Baik</span></a></li>                  
            @endrole
           
            @role(['superadmin','kurator'])
            <li class="menu-header">Kurator</li>
            <li><a class="nav-link" href="{{ URL::to('kurator/inovasi') }}"><i class="fas fa-list"></i> <span>Data Inovasi Praktik Baik</span></a></li>     
            <li><a class="nav-link" href="{{ URL::to('kurator/aksi-nyata') }}"><i class="fas fa-list"></i> <span>Data Aksi Nyata Praktik Baik</span></a></li>             
            @endrole

        </ul>

        {{-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div> --}}
    </aside>
</div>
