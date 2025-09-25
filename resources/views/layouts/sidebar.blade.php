 <style>
    .user-info {
        display: flex;
        align-items: center;
        padding-top: 5px; /* Sesuaikan jarak teks ke bawah sejauh 5 piksel */
    }

    .user-image {
        margin-right: 10px; /* Sesuaikan jarak antara gambar profil dengan nama pengguna */
    }

    .user-image img {
        width: 60px; /* Sesuaikan lebar gambar profil */
        height: 60px; /* Sesuaikan tinggi gambar profil */
        border-radius: 20%; /* Membuat gambar profil menjadi lingkaran */
        object-fit: cover; /* Memastikan gambar profil terpenuhi di dalam lingkaran */
    }

    .user-name {
        font-size: 1.5em; /* Sesuaikan ukuran teks nama pengguna */
    }

</style>

 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center user-info user-image" href="{{ route('home') }}">
                
                    <img src="{{ asset('assets/img/logo aliansyah.jpeg') }}" alt="Aliansyah Logo" class="img-circle" style="width: 30px ; height:auto">
                    <span class="sidebar-brand-text mx-2 user-name" style="font-size:15px ">{{ Auth::user()->name }}</span>
                   
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-light fa-house-user"></i>
                    <span>Home</span></a>
            </li>
            @if(Auth::user()->role== 'admin')
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('tambah-user.index') }}">
                    <i class="fas fa-light fa-file-excel"></i>
                    <span>Tambah User</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('presensi.index') }}">
                    <i class="fas fa-light fa-qrcode"></i>
                    <span>Rekap Presensi</span></a>
            </li>
            @elseif(Auth::user()->role== 'koordinator')
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('do.index') }}">
                    <i class="fas fa-light fa-qrcode"></i>
                    <span>Do Sales</span></a>
            </li>
            @else
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('presensi.index') }}">
                    <i class="fas fa-light fa-qrcode"></i>
                    <span>Absen Berangkat</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('presensi-pulang.index') }}">
                    <i class="fas fa-light fa-qrcode"></i>
                    <span>Absen Pulang</span></a>
            </li>
            @endif
            </ul>
            {{-- <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-light fa-file-excel"></i>
                    <span>Export</span></a>
            </li> --}}
            
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <i class="fas fa-light fa-user-plus"></i>
                    <span>Tambah User</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-light fa-folder-plus"></i>
                    <span>Management</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="#">Data User</a>
                         <a class="collapse-item" href="#">Stock Gudang</a>
                         <a class="collapse-item" href="#">Umpan Balik</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-sharp fa-light fa-cart-arrow-down"></i>
                    <span>Pembelian Stock</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                <i class="fas fa-sharp fa-light fa-handshake"></i>
                    <span>Penjualan / Penyewaan</span></a>
            </li>

            @elseif(Auth::user()->role == 'user')
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-light fa-house-user"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-sharp fa-light fa-cart-arrow-down"></i>
                    <span>Pembelian / Sewa</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-light fa-folder-plus"></i>
                    <span>Umpan Balik</span></a>
            </li>


            @elseif(Auth::user()->role == 'penyedia')

            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-light fa-house-user"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-light fa-folder-plus"></i>
                    <span>Umpan Balik</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-sharp fa-light fa-cart-arrow-down"></i>
                    <span>Pembelian Stock</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                <i class="fas fa-sharp fa-light fa-handshake"></i>
                    <span>Penjualan / Penyewaan</span></a>
            </li>

            @endif --}}
        