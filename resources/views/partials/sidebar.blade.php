<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Halo, {{ Auth::user()->name }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.laundries.index') }}"
                        class="nav-link {{ request()->is('admin/laundries') || request()->is('admin/laundries/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Mitra
                        </p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ml-3">
                            <a href="{{ route('admin.laundries.create') }}" class="nav-link">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <p>Tambah Mitra</p>
                            </a>
                        </li>
                        <li class="nav-item ml-3">
                            <a href="{{ route('admin.laundries.index') }}" class="nav-link">
                                <i class="far fa-handshake nav-icon"></i>
                                <p>Daftar Mitra</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.laundries.index') }}"
                        class="nav-link {{ request()->is('admin/admin') || request()->is('admin/admin/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Admin
                        </p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ml-3">
                            <a href="{{ route('admin.admin.create') }}" class="nav-link">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <p>Tambah Admin</p>
                            </a>
                        </li>
                        <li class="nav-item ml-3">
                            <a href="{{ route('admin.admin.index') }}" class="nav-link">
                                <i class="far fa-user nav-icon"></i>
                                <p>Daftar Admin</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.informations.index') }}"
                        class="nav-link {{ request()->is('admin/information') || request()->is('admin/information/*') ? 'active' : '' }}">
                        <i class="nav-icon fas ion-speakerphone"></i>
                        <p>
                            Informasi
                        </p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ml-3">
                            <a href="{{ route('admin.informations.create') }}" class="nav-link">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <p>Tambah Informasi</p>
                            </a>
                        </li>
                        <li class="nav-item ml-3">
                            <a href="{{ route('admin.informations.index') }}" class="nav-link">
                                <i class="far ion-speakerphone"></i>
                                <p>Daftar Informasi</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                    <form id="logoutform" action="{{ route('admin.logout') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
