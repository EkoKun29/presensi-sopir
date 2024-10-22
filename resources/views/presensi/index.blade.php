@extends('layouts.app')

@section('content')

<style>
    /* Mengatur video untuk responsif di dalam modal */
    #video {
        width: 100%; /* Menggunakan lebar penuh */
        max-width: 100%; /* Membatasi lebar maksimal */
        height: auto; /* Memastikan aspek rasio tetap */
    }
    #canvas {
        display: none; /* Sembunyikan canvas */
    }
    .modal-body {
        display: flex;
        flex-direction: column;
        align-items: center; /* Pusatkan konten dalam modal */
    }
    .button-container {
        display: flex;
        justify-content: space-between; /* Membagi ruang di antara tombol */
        width: 100%;
    }
</style>

<div id="content">
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                        </div>
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                <img class="img-profile rounded-circle"
                                    src="../../assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <div class="container-fluid">
             
        <div class="container-fluid">
        <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Data Presensi</h6>
                            <a href="#" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-report">
                                <i class="fas fa-plus fa-sm text-white-50"></i> PRESENSI
                            </a>
                        </div>
                        <br>
                               <form action="#" class="form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                <div class="input-group">
                                    <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search fa-fw"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        <div class="card-body">
                                <div class="table-responsive">
                                <table id="myTable" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            {{-- <th>Nama</th>
                                            <th>Jabatan</th> --}}
                                            <th>Lokasi</th>
                                            <th>Ket</th>
                                            {{-- <th>Aksi</th> --}}
                                        </tr>
                                    </thead>
                                    <?php $no =1 ; ?>
                                    <tbody>
                                    {{-- @foreach ($scan as $u)
                                        <tr>
                                            <td style="text-align:center">{{ $no++ }}</td>
                                            <td>{{ \Carbon\Carbon::parse($u->created_at)->format('Y-m-d') }}</td>
                                            <td>{{ $u->no_seri }}</td>
                                            <td>{{ $u->no_seri_akhir }}</td>
                                            <td>{{ $u->jenis_tanaman }}</td>
                                            <td>{{ $u->varietas }}</td>
                                            <td>{{ $u->no_kelompok }}</td>
                                            <td style="text-align:center"><div class="btn-list flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-success dropdown-toggle align-text-top"
                                                        data-bs-toggle="dropdown">
                                                        Aksi
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                                            data-bs-target="#modal-edit-{{ $u->id }}">Edit</button>
                                                        <a href="{{ route('scan.print', $u['uuid']) }}" class="dropdown-item text-success">Cetak</a>
                                                        <form action="{{ route('scan.download') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="uuid" value="{{ $u->uuid }}">
                                                        <button type="submit" class="dropdown-item text-info">Download</button>
                                                    </form>

                                                        <a href="{{ route('scan.delete', $u['id']) }}" id="btn-delete-post" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data {{ $u->varietas }} Ini ??')"
                                                            value="Delete" class="dropdown-item text-danger">Hapus</a>
                                                    </div>
                                                </div>
                                            </div>
                                            </td>
                                            @include('scan.edit')
                                        </tr>
                                    @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                             <div class="d-flex mt-3 justify-content-end">
                        {{-- {{ $scan->links() }} --}}
                    </div>
                        </div>
                    </div>
                    </div>
                    </div>
@include('presensi.create')
@endsection
@push('js')
<script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const context = canvas.getContext('2d');

        // Fungsi untuk menangani kesalahan akses kamera
        function handleError(error) {
            console.error('Terjadi kesalahan saat mengakses kamera:', error);
        }

        // Akses kamera melalui getUserMedia
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                video.srcObject = stream; // Tampilkan stream video di elemen <video>
            })
            .catch(handleError); // Jika ada error, tangkap dan tampilkan

        // Ketika tombol 'Ambil Foto' ditekan
        snap.addEventListener('click', function () {
            context.drawImage(video, 0, 0, 320, 240); // Ambil gambar dari video
            const dataURL = canvas.toDataURL('image/png'); // Convert gambar ke Base64
            console.log('Gambar diambil:', dataURL); // Cetak hasil base64 ke console untuk debug
        });

        cancelButton.addEventListener('click', function () {
        if (videoStream) {
            videoStream.getTracks().forEach(track => track.stop()); // Hentikan semua track dari stream
        }
    });
    </script>


@endpush