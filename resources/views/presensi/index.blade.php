@extends('layouts.app')

@section('content')

<style>
    
    #video { 
    width: 100%;            /* Lebar penuh layar */
    max-width: 100%;        /* Batas lebar maksimal 100% */
    height: auto;           /* Aspek rasio tetap */
    border-radius: 10px;    /* Sudut membulat */
    object-fit: cover;      /* Menjaga rasio video dalam elemen */
    transform: scaleX(-1);  /* Efek mirror pada video */
    }

    #canvas {
        width: 100%;            /* Menyesuaikan lebar dengan layar */
        max-width: 100%;        /* Batas lebar maksimal 100% */
        height: auto;           /* Aspek rasio tetap */
        border-radius: 10px;    /* Sama dengan video */
        transform: scaleX(-1);  /* Efek mirror pada hasil gambar */
        display: none;          /* Sembunyikan canvas sampai dibutuhkan */
    }

     .camera-btn {
        background-color: #007bff; /* Warna biru */
        color: white;
        border: none;
        border-radius: 50%; /* Membuat bentuk lingkaran */
        width: 70px; /* Lebar lingkaran */
        height: 70px; /* Tinggi lingkaran */
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px; /* Ukuran ikon */
        cursor: pointer;
        outline: none;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); /* Tambahkan bayangan */
    }
    .camera-btn:active {
        transform: scale(0.95); /* Efek klik */
    }

    .camera-btn i {
        margin: 0;
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
        @if(Auth::user()->role== 'admin')
            <div class="card shadow mb-4">
    <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Rekap Presensi Lapangan</h6>
    </div>
    <br>
    <form action="{{ route('absensi.search') }}" method="GET" class="form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
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
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($presensis as $p)
                    <tr>
                        <td style="text-align:center">{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('Y-m-d') }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->jabatan }}</td>
                        <td style="text-align:center">
                            <div class="btn-list flex-nowrap">
                                <div class="dropdown">
                                    <button class="btn btn-outline-success dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- Tombol Detail -->
                                        <a class="dropdown-item text-warning" href="{{ route('presensi.show.detail', ['nama' => $p->nama, 'tanggal' => $p->tanggal]) }}">
                                            Detail
                                        </a>
                                        <a href="{{ route('presensi.delete.detail', ['nama' => $p->nama, 'tanggal' => $p->tanggal]) }}" 
                                            id="btn-delete-post" 
                                            onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data {{ $p->nama }} Ini ??')" 
                                            value="Delete" 
                                            class="dropdown-item text-danger">
                                            Hapus
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex mt-3 justify-content-end">
            {{ $presensis->links() }} <!-- Jika Anda menggunakan pagination -->
        </div>
    </div>
</div>


        @else
        <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Data Presensi</h6>
                            <a href="#" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-report">
                                <i class="fas fa-plus fa-sm text-white-50"></i> PRESENSI
                            </a>
                        </div>
                        <br>
                               {{-- <form action="{{ route('absensi.search') }}" method="GET" class="form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                <div class="input-group">
                                    <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search fa-fw"></i>
                                        </button>
                                    </div>
                                </div>
                            </form> --}}
                        <div class="card-body">
                                <div class="table-responsive">
                                <table id="myTable" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            {{-- <th>Lokasi</th> --}}
                                            <th>Ket</th>
                                        </tr>
                                    </thead>
                                    <?php $no =1 ; ?>
                                    <tbody>
                                    @foreach ($presensis as $p)
                                        <tr>
                                            <td style="text-align:center">{{ $no++ }}</td>
                                            <td>{{ \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($p->created_at)->format('H:i') }}</td>
                                            {{-- <td>{{ $p->lokasi}}</td> --}}
                                            <td>
                                                @php
                                                    $time = \Carbon\Carbon::parse($p->created_at)->format('H:i');
                                                @endphp

                                                @if ($time >= '06:00' && $time < '11:00')
                                                    Pagi
                                                @elseif ($time >= '11:01' && $time < '15:00')
                                                    Siang
                                                @elseif ($time >= '15:01' && $time < '17:00')
                                                    Sore
                                                @elseif (($time >= '17:01' && $time <= '24:00') || ($time >= '00:01' && $time < '06:00'))
                                                    Malam
                                                @else
                                                    Tidak diketahui
                                                @endif
                                            </td>
            
                                            
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                             <div class="d-flex mt-3 justify-content-end">
                        {{ $presensis->links() }}
                    </div>
                </div>
            </div>
            </div>
        </div>
        @endif
@include('presensi.create')
@endsection
@push('js')
<script>
    // Element reference
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const snapButton = document.getElementById('snap');
    const photoInput = document.getElementById('photoInput');
    const shutterSound = document.getElementById('shutterSound');
    const saveButtonContainer = document.getElementById('saveButtonContainer');
    // const latitudeInput = document.getElementById('latitudeInput');
    // const longitudeInput = document.getElementById('longitudeInput');
    const closeCanvasButton = document.getElementById('closeCanvasButton');

    // Accessing the webcam
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
        })
        .catch((err) => {
            console.error("Error accessing webcam:", err);
        });

    // Capture image when "Capture Image" button is clicked
    snapButton.addEventListener('click', (event) => {
        event.preventDefault();
        shutterSound.play();

        // Set canvas size to video size and reset transformations
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.setTransform(1, 0, 0, 1, 0, 0);

        // Draw image on canvas and switch visibility
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        video.style.display = 'none';
        canvas.style.display = 'block';
        saveButtonContainer.style.display = 'block';

        // Convert canvas to data URI and store in hidden input
        photoInput.value = canvas.toDataURL('image/png');

        // Retrieve location (latitude and longitude)
        // if (navigator.geolocation) {
        //     navigator.geolocation.getCurrentPosition(
        //         (position) => {
        //             latitudeInput.value = position.coords.latitude;
        //             longitudeInput.value = position.coords.longitude;
        //             console.log('Latitude:', position.coords.latitude, 'Longitude:', position.coords.longitude);
        //         },
        //         (error) => {
        //             console.error("Error obtaining location:", error);
        //             alert("Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan.");
        //         },
        //         {
        //             enableHighAccuracy: true,
        //             timeout: 10000,
        //             maximumAge: 0
        //         }
        //     );
        // } else {
        //     alert("Geolocation tidak didukung oleh browser Anda.");
        // }
    });

    // Close canvas view when "Cancel" button is clicked
    closeCanvasButton.addEventListener('click', (event) => {
        event.preventDefault();
        canvas.style.display = 'none';
        video.style.display = 'block';
        saveButtonContainer.style.display = 'none';
        photoInput.value = '';
    });
</script>
@endpush
