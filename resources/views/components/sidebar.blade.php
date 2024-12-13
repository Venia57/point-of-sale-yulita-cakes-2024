<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: rgb(167, 108, 108);">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('logo-pink.jpeg') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">Yulita Cakes</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('images/' . Auth::user()->foto_profil) }}" class="img-circle elevation-2"
                    alt="User Image" />
            </div>
            <div class="info">
                <a href="{{ route('kelola_akun') }}" class="d-block">{{ Auth::user()->nama }}</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon ion ion-grid"></i>
                        <p>
                            MENU
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kasir') }}"
                                class="nav-link {{ request()->is('kasir') ? 'active' : '' }}">
                                <i class="fas fa-cash-register nav-icon"></i>
                                <p>Kasir</p>
                            </a>
                        </li>
                        @can('admin')
                            <li class="nav-item">
                                <a href="{{ route('kategori') }}"
                                    class="nav-link {{ request()->is('kategori') ? 'active' : '' }}">
                                    <i class="fas fa-cube nav-icon"></i>
                                    <p>Kategori</p>
                                </a>
                            </li>
                        @endcan
                        @can('admin')
                            <li class="nav-item">
                                <a href="{{ route('produk') }}"
                                    class="nav-link {{ request()->is('produk') ? 'active' : '' }}">
                                    <i class="fas fa-cubes nav-icon"></i>
                                    <p>Produk</p>
                                </a>
                            </li>
                        @endcan
                        @can('admin')
                            <li class="nav-item">
                                <a href="{{ route('pengeluaran') }}"
                                    class="nav-link {{ request()->is('pengeluaran') ? 'active' : '' }}">
                                    <i class="fas fa-dollar-sign nav-icon"></i>
                                    <p>Pengeluaran</p>
                                </a>
                            </li>
                        @endcan
                        @can('admin')
                            <li class="nav-item">
                                <a href="{{ route('penjualan') }}"
                                    class="nav-link {{ request()->is('penjualan') ? 'active' : '' }}">
                                    <i class="fas fa-download nav-icon"></i>
                                    <p>Detail Penjualan</p>
                                </a>
                            </li>
                        @endcan
                        @can('admin')
                            <li class="nav-item">
                                <a href="{{ route('laporan') }}"
                                    class="nav-link {{ request()->is('laporan') ? 'active' : '' }}">
                                    <i class="ion ion-stats-bars nav-icon"></i>
                                    <p>Laporan</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon ion ion-person"></i>
                        <p>
                            Akun
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('kelola_akun') }}"
                                class="nav-link {{ request()->is('kelola_akun') ? 'active' : '' }}">
                                <i class="ion ion-settings nav-icon"></i>
                                <p>Kelola Akun</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link" id="tombol-keluar">
                                <i class="ion ion-log-out nav-icon"></i>
                                <p>keluar</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
