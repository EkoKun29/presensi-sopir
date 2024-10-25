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
        <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
                            <a href="#" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-report">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah User
                            </a>
                        </div>
                        <br>
                               <form action="{{ route('user.search') }}" class="form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
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
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php $no =1 ; ?>
                                    <tbody>
                                    @foreach ($user as $u)
                                        <tr>
                                            <td style="text-align:center">{{ $no++ }}</td>
                                            <td>{{ $u->name }}</td>
                                            <td>{{ $u->email }}</td>
                                            <td style="text-align:center"><div class="btn-list flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-success dropdown-toggle align-text-top"
                                                        data-bs-toggle="dropdown">
                                                        Aksi
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="{{ route('user.delete', $u['id']) }}" id="btn-delete-post" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data {{ $u->varietas }} Ini ??')"
                                                            value="Delete" class="dropdown-item text-danger">Hapus</a>
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
                        {{ $user->links() }}
                    </div>
                        </div>
                    </div>
                    </div>
                    </div>
@include('tambah-user.create')
@endsection
@push('js')
 <script>
 new DataTable('#myTable', {
            searchable: true,
            fixedHeight: true
        });
        
    </script>
@endpush