<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>
                @php
                $photo = auth()->user()->photo;
                $gender = auth()->user()->gender;
                $avartar = ($gender == 'Male' || $gender == 'male' || $gender == 'MALE') ? 'avartar-m' : 'avartar-f';
                $photo_path = ($photo != '' && file_exists($photo)) ? "/".auth()->user()->photo : "/assets/img/" . $avartar . '.png' @endphp
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img src="{{ $photo_path }}" class="avatar img-fluid rounded-circle me-1" alt="{{ auth()->user()->firstname." ".auth()->user()->lastname }}" /> <span class="text-dark">{{ auth()->user()->firstname." ".auth()->user()->lastname }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="/profile"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('signout') }}">
                        <i class="align-middle me-2" data-feather="power"></i> {{ __('Sign out') }}
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>