<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
             <form action="#" method="POST">
                @csrf
                <div class="modal-body">
                            <video id="video" autoplay></video>
                            <canvas id="canvas" width="320" height="240"></canvas>
                            <button id="snap" class="btn btn-primary mt-2">Ambil Foto</button>
                            <div class="button-container">
                                <a href="#" id="cancelButton" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</a>
                            </div>
                        </div>
            </form>
        </div>
    </div>
</div>



