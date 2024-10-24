<div class="modal modal-blur fade" id="modal-edit-{{ $p->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Presensi</h5>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">No. Induk</label>
                                <input type="text" name="induk" class="form-control" placeholder="Nomor Induk" value="{{ $u->no_induk }}" required>
                            </div>
                            
                        </div>
                        <div class="col">
                            {{-- <div class="mb-3">
                                <label class="form-label">Biji Gulma</label>
                                <input type="number" step="any" name="biji" class="form-control" placeholder="Biji Gulma" value="{{ $u->biji_gulma }}" required>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-danger" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        Simpan
                    </button>
            </form>
        </div>
    </div>
</div>


