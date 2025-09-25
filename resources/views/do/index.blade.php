@extends('layouts.app')

@section('content')



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
    <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Do Sales</h6>
        <a href="{{ route('do.create') }}" class="btn btn-sm btn-primary shadow-sm" >
            <i class="fas fa-plus fa-sm text-white-50"></i> Input DO
        </a>
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
                        <th>Nomor Surat</th>
                        <th>Sales</th>
                        <th>Kios</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($do as $p)
                    <tr>
                        <td style="text-align:center">{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') }}</td>
                        <td>{{ $p->nomor_surat }}</td>
                        <td>{{ $p->sales }}</td>
                        <td>{{ $p->kios }}</td>
                        <td style="text-align:center">
                            <a href="{{ route('do.show', $p->id) }}" class="btn btn-warning btn-sm " >
                                            Detail Do
                            </a> |
                            <a href="{{ route('do.editKopDo', $p->id) }}" class="btn btn-success btn-sm " >
                                            Revisi Kop
                            </a> | 
                              
                                  <a href="{{ route('do.hapusSurat', $p->id) }}" class="btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                              
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex mt-3 justify-content-end">
            {{ $do->links() }} <!-- Jika Anda menggunakan pagination -->
        </div>
    </div>
</div>


        
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
