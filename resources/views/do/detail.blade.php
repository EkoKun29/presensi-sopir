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

                        <!-- Page Heading -->
        
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Detail Sales Do</h1>
            </div>

            <div class="row">
                

                    <div class="col-12">

          <div class="invoice p-3 mb-3">

              <div class="row invoice-info">
                <div class="col-sm-3 invoice-col">
                  Nomor Surat
                  <address>
                  <strong>{{ $detail->nomor_surat }}</strong><br>
                  
                  </address>
                </div>

                <div class="col-sm-3 invoice-col">
                  Customer
                  <address>
                    <strong>{{ $detail->kios }}</strong><br>
                  </address>
                </div>

                <div class="col-sm-3 invoice-col">
                  Sales
                  <address>
                  <strong>{{ $detail->sales }}</strong><br>
                  
                  </address>
                </div>

                <div class="col-sm-3 invoice-col">
                  Tanggal
                  <address>
                  <strong>{{ date('Y-m-d', strtotime($detail->created_at)) }}</strong><br>
                  
                  </address>
                </div>

              </div>

              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Dus/Sak</th>
                        <th>Btl/Bks</th>
                        
                        <th>Action</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                       $no = 1;
                      ?>
                      @foreach($detail->detail_do as $dk)
                      <tr>
                        <td>{{$no++}}</td>
                        <td>{{$dk->produk}}</td>
                        <td>{{$dk->dus}}</td>
                        <td>{{$dk->btl}}</td>
                        <td>
                          <a href="{{ route('do.edit2', $dk->id) }}" class="btn-sm btn-warning">Revisi</a>
                          <form action="{{ route('do.destroy', $dk->id) }}" method="POST" style="display:inline;">
                            @csrf
                              @method('DELETE')
                              <button type="submit" class="btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                          </form>
                        </td>
                        
                      </tr>
                      @endforeach

                    </tbody>
                  </table>
                </div>

              </div>
          </div>
        </div>
                
            </div>
        
    </div>
</div>
@endsection
@push('js')
<script>
        new TomSelect("#select-barang", {
            create: false,
        });

        new TomSelect("#select-sales", {
            create: false,
        });
    </script>
@endpush

