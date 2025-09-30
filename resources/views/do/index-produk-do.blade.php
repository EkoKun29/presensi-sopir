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
                        <th>Produk</th>
                        <th>Dus</th>
                        <th>Btl</th>
                        <th>Laba</th>
                        {{-- <th>Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($do as $p)
                    <tr>
                        <td style="text-align:center">{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') }}</td>
                        <td>{{ $p->do->nomor_surat }}</td>
                        <td>{{ $p->do->sales }}</td>
                        <td>{{ $p->do->kios }}</td>
                        <td>{{ $p->produk }}</td>
                        <td>{{ $p->dus }}</td>
                        <td>{{ $p->btl }}</td>
                        <td>
                            @if($p->laba < 0)
                            <b><code>{{ 'Rp ' . number_format($p->laba, 0, ',', '.') }}</code></b>
                            @else
                            <b><code style="color: green">{{ 'Rp ' . number_format($p->laba, 0, ',', '.') }}</code></b>
                            @endif

                          </td>
                        {{-- <td style="text-align:center">
                            <a href="{{ route('do.show', $p->id) }}" class="btn btn-warning btn-sm " >
                                            Detail Do
                            </a> |
                            <a href="{{ route('do.editKopDo', $p->id) }}" class="btn btn-success btn-sm " >
                                            Revisi Kop
                            </a> | 
                              
                                  <a href="{{ route('do.hapusSurat', $p->id) }}" class="btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                              
                        </td> --}}
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
    
</script>
@endpush
