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
                <h1 class="h3 mb-0 text-gray-800">Form Sales Do</h1>
            </div>

            <div class="row">
                

                    <div class="col-lg-6">
                        <div class="card shadow mb-6">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Form Sales Do</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('do.store') }}" method="POST">
                                @csrf

                                    <div class="card-body">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Sales</label>
                                          {{-- <input type="text" class="form-control" id="yourInput" placeholder="Masukkan nama barang">
                                          <ul id="optionList"></ul> --}}
                                          <select id="select-sales" name="sales" autocomplete="off" required >
                                              <option value="" selected>Sales</option>
                                              {{-- @foreach ($dataApi as $b) --}}
                                                  {{-- @if(is_array($b))
                                                      <option value="{{ $b['barang'] }}">{{ $b['barang'] }}</option>
                                                  @elseif(is_object($b))
                                                      <option value="{{ $b->barang }}">{{ $b->barang }}</option>
                                                  @endif --}}
                                                  @foreach($sales as $b1)
                                                      <option value="{{ $b1->nama_sales }}">{{ $b1->nama_sales }}</option>
                                                  @endforeach
                                              {{-- @endforeach --}}
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Kios</label>
                                          {{-- <input type="text" class="form-control" id="yourInput" placeholder="Masukkan nama barang">
                                          <ul id="optionList"></ul> --}}
                                          <select id="select-barang" name="kios" autocomplete="off" required >
                                              <option value="" selected>Kios</option>
                                              {{-- @foreach ($dataApi as $b) --}}
                                                  {{-- @if(is_array($b))
                                                      <option value="{{ $b['barang'] }}">{{ $b['barang'] }}</option>
                                                  @elseif(is_object($b))
                                                      <option value="{{ $b->barang }}">{{ $b->barang }}</option>
                                                  @endif --}}
                                                  @foreach($kios as $b2)
                                                      <option value="{{ $b2->nama }}">{{ $b2->nama }}</option>
                                                  @endforeach
                                              {{-- @endforeach --}}
                                          </select>
                                      </div>

                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Yang Bawa</label>
                                          {{-- <input type="text" class="form-control" id="yourInput" placeholder="Masukkan nama barang">
                                          <ul id="optionList"></ul> --}}
                                          <select id="select-helper" name="dropper" autocomplete="off" required >
                                              <option value="" selected>Yang Bawa</option>
                                              {{-- @foreach ($dataApi as $b) --}}
                                                  {{-- @if(is_array($b))
                                                      <option value="{{ $b['barang'] }}">{{ $b['barang'] }}</option>
                                                  @elseif(is_object($b))
                                                      <option value="{{ $b->barang }}">{{ $b->barang }}</option>
                                                  @endif --}}
                                                  @foreach($helper as $h2)
                                                      <option value="{{ $h2->helper }}">{{ $h2->helper }}</option>
                                                  @endforeach
                                              {{-- @endforeach --}}
                                          </select>
                                      </div>
                                      
                                      
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                      <button type="submit" class="btn btn-primary">Barang</button>
                                    </div>
                                </form>
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

        new TomSelect("#select-helper", {
            create: false,
        });
    </script>
@endpush

