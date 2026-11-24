<nav class="navbar navbar-expand-lg main-navbar" aria-label="Navigasi akun">
    <ul class="navbar-nav mr-auto">
        <li>
            <button type="button" class="btn btn-link nav-link nav-link-lg" data-toggle="sidebar"
                aria-controls="sidebar-wrapper" aria-label="Buka atau tutup menu">
                <i class="fas fa-bars" aria-hidden="true"></i>
            </button>
        </li>
    </ul>

    <ul class="navbar-nav">
        <li class="dropdown">
            <button type="button" class="btn btn-link nav-link dropdown-toggle nav-link-lg nav-link-user"
                data-toggle="dropdown" aria-expanded="false" aria-label="Menu akun">
                <i class="fas fa-user-circle mr-1" aria-hidden="true"></i>
                <span>{{ auth()->user()->name }}</span>
            </button>

            <div class="dropdown-menu dropdown-menu-right">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Keluar
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
