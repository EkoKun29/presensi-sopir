@extends('layouts.app')

@section('content')
<div id="content">
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>
        <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                    <img class="img-profile rounded-circle" src="../../assets/img/undraw_profile.svg">
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
        <h6 class="m-0 font-weight-bold text-primary">Rekap Data</h6>
        <div class="card shadow mb-4">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Waktu</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataPresensi as $presensi)
                        <tr>
                            <td>
                                @if($presensi->face) 
                                    <img src="{{ asset('storage/' . $presensi->face) }}" alt="Foto Presensi" style="width: 100px; height: 92px;">
                                @else
                                    <span>Foto tidak tersedia</span>
                                @endif
                            </td>
                            {{-- <td>{{ $presensi->lokasi ?? 'Lokasi tidak tersedia' }}</td> --}}
                            <td>{{ $presensi->jam ?? 'Waktu tidak tersedia' }}</td>
                            <td>{{ $presensi->keterangan }}</td>
                        </tr>
                        @endforeach
                    {{-- </tbody>
                </table>

                <table class="table">
                    <tbody> --}}
                        @foreach($dataPresensiPulang as $presensiPulang)
                        <tr>
                            <td>
                                @if($presensiPulang->face) 
                                    <img src="{{ asset('storage/' . $presensiPulang->face) }}" alt="Foto Presensi Pulang" style="width: 100px; height: 92px;">
                                @else
                                    <span>Foto tidak tersedia</span>
                                @endif
                            </td>
                            {{-- <td>{{ $presensiPulang->lokasi ?? 'Lokasi tidak tersedia' }}</td> --}}
                            <td>{{ $presensiPulang->jam ?? 'Waktu tidak tersedia' }}</td>
                            <td>{{ $presensiPulang->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>    
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
