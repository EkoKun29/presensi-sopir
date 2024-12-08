<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReportLabel">Presensi</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="photoForm" action="{{ route('presensi.store') }}" method="POST">
                @csrf
                <div class="modal-body d-flex justify-content-center position-relative">
                    <video id="video" autoplay></video>
                    <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
                    <button id="snap" type="button" class="camera-btn">
                        <i class="fas fa-camera"></i>
                    </button>
                    <audio id="shutterSound" src="../../assets/sounds/shutter.mp3" preload="auto"></audio>
                </div>
                <!-- Input hidden untuk menyimpan gambar -->
                <input type="hidden" name="photo" id="photoInput">
                <!-- Input hidden untuk latitude dan longitude -->
                {{-- <input type="hidden" name="latitude" id="latitudeInput">
                <input type="hidden" name="longitude" id="longitudeInput"> --}}
                <!-- Tombol simpan baru muncul setelah gambar ditangkap -->
                <div class="modal-footer" id="saveButtonContainer" style="display: none;">
                    <button type="submit" class="btn btn-outline-danger">Save Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>