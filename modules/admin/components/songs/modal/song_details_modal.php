<div class="modal fade" id="songDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg">
            
            <!-- HEADER -->
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title fw-bold">
                    <i class="material-symbols-rounded me-1">music_note</i> Song Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">
                <h4 id="songTitle" class="fw-bold text-primary"></h4>
                <p class="text-muted mb-1"><strong>Artist:</strong> <span id="songArtist"></span></p>
                <p class="text-muted mb-1"><strong>Key:</strong> <span id="songKey"></span></p>
                <p class="text-muted mb-1"><strong>BPM:</strong> <span id="songBpm"></span></p>

                <hr>

                <h6 class="fw-bold mb-2">Lyrics</h6>
                <pre id="songLyrics" class="bg-light p-3 rounded" style="white-space: pre-wrap;"></pre>

                <h6 class="fw-bold mt-3">Notes</h6>
                <p id="songNotes" class="text-muted"></p>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer bg-light rounded-bottom-4">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <button class="btn btn-primary" id="btnEditSong">
                        <i class="material-symbols-rounded me-1">edit</i> Edit
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
