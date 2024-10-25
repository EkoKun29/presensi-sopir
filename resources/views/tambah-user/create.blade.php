<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
           <div class="modal-header">
                <h5 class="modal-title">Form Input Data</h5>
            </div>
            <form action="{{ route('tambah-user.store') }}" method="POST">
              @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <select id="role" name="role" class="form-control">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="sopir">Sopir</option>
                                    <option value="helper">Helper</option>
                                    <option value="sales">Sales</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" step="any" name="email" class="form-control" placeholder="Masukkan email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" step="any" name="password" class="form-control" placeholder="Masukkan Password" required>
                            </div>
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
                </div>
            </form>
        </div>
    </div>
</div>
