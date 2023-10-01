<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ URL::to('') }}/{{ auth()->user()->bio->profile_picture ?? 'assets/img/avatar/avatar-1.png' }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi,                    
                    {{ Auth()->user()->bio->nama ?? Auth()->user()->email}} </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                @php
                    $user = Auth()->user()->id;                   
                    $date = App\Models\User::find($user)->lastSuccessfulLoginAt();
                @endphp
                <div class="dropdown-title">{{ \Carbon\Carbon::parse($date)->diffForHumans() }}</div>
                <a href="{{ URL::to('biodata') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="{{ URL::to('ganti-password') }}" class="dropdown-item has-icon">
                    <i class="fas fa-key"></i> Ganti Sandi
                </a>
                <div class="dropdown-divider"></div>
                <form action="/logout" method="POST">
                    @csrf
                    <button class="dropdown-item has-icon text-danger"> Logout</button>
                </form>
                {{-- <a href="/logout" class="">
                     Logout
                </a> --}}
            </div>
        </li>
    </ul>
</nav>
