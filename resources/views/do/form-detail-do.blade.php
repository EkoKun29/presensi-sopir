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
                <h1 class="h3 mb-0 text-gray-800">Form Detail Sales Do {{$do->sales}}</h1>
            </div>

            <div class="row">
                

                    <div class="col-lg-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Form Detail Sales Do {{$do->sales}}</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('do.simpanDetailStore', $do->id) }}" method="POST">
                                @csrf

                                    <div class="card-body">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Surat</label>
                                          <input type="text" class="form-control" id="yourInput" value="{{$do->nomor_surat}}" readonly="">
                                          
                                          
                                      </div>
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Produk</label>
                                          {{-- <input type="text" class="form-control" id="yourInput" placeholder="Masukkan nama barang">
                                          <ul id="optionList"></ul> --}}
                                          <select id="select-sales" name="produk" autocomplete="off" required >
                                              <option value="" selected>Produk</option>
                                              {{-- @foreach ($dataApi as $b) --}}
                                                  {{-- @if(is_array($b))
                                                      <option value="{{ $b['barang'] }}">{{ $b['barang'] }}</option>
                                                  @elseif(is_object($b))
                                                      <option value="{{ $b->barang }}">{{ $b->barang }}</option>
                                                  @endif --}}
                                                  @foreach($produk as $b1)
                                                      <option value="{{ $b1->id }}">{{ $b1->nama }}</option>
                                                  @endforeach
                                              {{-- @endforeach --}}
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Dus</label>
                                          <input type="number" class="form-control" id="yourInput" name="dus" placeholder="Masukkan dus" required="">
                                          
                                          
                                      </div>
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Btl</label>
                                          <input type="number" class="form-control" id="yourInput" name="btl" placeholder="Masukkan btl" required="">
                                          
                                          
                                      </div>
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Harga</label>
                                          <input type="number" class="form-control" id="yourInput" name="harga" placeholder="Masukkan Harga" required="">
                                          
                                          
                                      </div>
                                      
                                      
                                      
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                      <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-8">
                        <div class="card shadow mb-8">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Detail Sales Do {{$do->sales}}</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                  <table id="myTable" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                      <thead style="text-align:center">
                                          <tr>
                                              <th>#</th>
                                              <th>Produk</th>
                                              <th>Dus</th>
                                              <th>Btl</th>
                                              <th>laba</th>
                                              <th>Aksi</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php $no = 1; ?>
                                          @foreach ($do->detail_do as $p)
                                          <tr>
                                              <td style="text-align:center">{{ $no++ }}</td>
                                              <td>{{ $p->produk }}</td>
                                              <td>{{ $p->dus }}</td>
                                              <td>{{ $p->btl }}</td>
                                              <td>
                                                @if($p->laba < 0)
                                                <span class="btn-sm btn-danger">{{ 'Rp ' . number_format($p->laba, 0, ',', '.') }}</span>
                                                @else
                                                <span class="btn-sm btn-success">{{ 'Rp ' . number_format($p->laba, 0, ',', '.') }}</span>
                                                @endif

                                              </td>
                                              <td style="text-align:center">
                                                  <div class="btn-list flex-nowrap">
                                                      <div class="dropdown">
                                                          <a href="{{ route('do.edit', $p->id) }}" class="btn btn-success btn-sm " >
                                                              Revisi
                                                          </a> | 
                                                          <form action="{{ route('do.destroy', $p->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                              @method('DELETE')
                                                              <button type="submit" class="btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                                                          </form>
                                                          
                                                      </div>
                                                  </div>
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
        
        new TomSelect("#select-sales", {
            create: false,
        });
    </script>
@endpush

