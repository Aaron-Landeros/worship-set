<div class="modal fade" id="manageSetlistModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg">

            <!-- HEADER -->
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title fw-bold">
                    <i class="material-symbols-rounded align-middle me-1">music_note</i> Manage Worship Setlist
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">
                <ul class="nav nav-tabs mb-4" id="setlistTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="tab-setlist" data-bs-toggle="tab" data-bs-target="#tabSetlist" type="button" role="tab">
                            <i class="material-symbols-rounded me-1">playlist_play</i> Setlist
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tab-assignments" data-bs-toggle="tab" data-bs-target="#tabAssignments" type="button" role="tab">
                            <i class="material-symbols-rounded me-1">group</i> Assign Musicians
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- TAB 1: Setlist -->
                    <div class="tab-pane fade show active" id="tabSetlist" role="tabpanel">
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">Add a Song</h6>
                            <div class="row g-3 align-items-end">
                                <div class="col-md-6">
                                    <label class="form-label">Song</label>
                                    <select id="song_to_select" class="form-select">
                                        <option value="">Select a song</option>
                                        <?php foreach ($songs as $song): ?>
                                            <option value="<?= $song['id'] ?>">
                                                <?= htmlspecialchars($song['title']) ?> — <?= htmlspecialchars($song['artist']) ?> (<?= $song['key_signature'] ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Key</label>
                                    <select id="song_key" class="form-select">
                                        <option value="">Original</option>
                                        <option value="C">C</option>
                                        <option value="Db">Db</option>
                                        <option value="D">D</option>
                                        <option value="Eb">Eb</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                        <option value="Gb">Gb</option>
                                        <option value="G">G</option>
                                        <option value="Ab">Ab</option>
                                        <option value="A">A</option>
                                        <option value="Bb">Bb</option>
                                        <option value="B">B</option>
                                    </select>
                                </div>
                                <div class="col-md-3 text-end">
                                    <button class="btn btn-success w-100" data-service-id="<?= $service_id ?>" data-segment-id="<?= $segment_id ?>" id="btn_add_song_to_setlist">
                                        <i class="material-symbols-rounded align-middle">add</i> Add
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">Current Setlist</h6>
                            <p class="small text-muted mb-0">Drag & drop to reorder the songs.</p>
                            <div id="setlist_songs" class="d-flex flex-column gap-2">
                                <?php

                                if (empty($setlist)): ?>
                                    <div class="text-muted text-center small py-3">
                                        No songs added yet
                                    </div>
                                <?php else: ?>

                                    <?php
                                        foreach($setlist as $song):
                                            $song_id = $song['song_id'];
                                            $song_key = $song['key_signature'] ?: 'Original';
                                            $song = fetch_song_data($db, $song_id);
                                            
                                            include '../components/services/components/card/setlist_songs_card.php';
                                        endforeach; 
                                    ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: Assignments -->
                    <div class="tab-pane fade" id="tabAssignments" role="tabpanel">
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="material-symbols-rounded me-1">group</i> Assign Musicians & Singers
                            </h6>

                            <!-- Barra de búsqueda y filtros -->
                            <div class="d-flex gap-2 mb-3">
                                <input type="text" id="musicianSearch" class="form-control form-control-sm" placeholder="Search musician...">
                                <select id="filterRole" class="form-select form-select-sm" style="width: 150px;">
                                    <option value="">All</option>
                                    <option value="musician">Musicians</option>
                                    <option value="singer">Singers</option>
                                </select>
                            </div>

                            <!-- Contenedor dinámico -->
                            <div class="row g-3" id="musicianAssignmentsGrid">
                                <!-- Ejemplo de Card -->
                                <div class="col-12 col-md-6 col-lg-4 musician-card" data-role="musician">
                                    <div class="card shadow-sm border-0 h-100">
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="https://ui-avatars.com/api/?name=Nohemí+Landeros&background=random&size=64&rounded=true"
                                                    class="rounded-circle me-3" width="48" height="48">
                                                <div>
                                                    <h6 class="fw-bold mb-0">Nohemí Landeros</h6>
                                                    <small class="text-muted">Position: Vocal</small>
                                                </div>
                                            </div>
                                            <!-- Selector de rol -->
                                            <div class="mb-2">
                                                <label class="form-label small">Role</label>
                                                <select class="form-select form-select-sm musician-role">
                                                    <option value="">Select Role</option>
                                                    <option value="Vocal">Vocal</option>
                                                    <option value="Guitar">Guitar</option>
                                                    <option value="Drums">Drums</option>
                                                    <option value="Bass">Bass</option>
                                                    <option value="Keyboard">Keyboard</option>
                                                </select>
                                            </div>
                                            <!-- Selector dinámico de canción (si es vocal) -->
                                            <div class="song-select-wrapper d-none">
                                                <label class="form-label small">Assigned Song</label>
                                                <select class="form-select form-select-sm song-select">
                                                    <option value="">Choose Song</option>
                                                    <!-- Canciones del setlist se cargan dinámicamente -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer bg-light rounded-bottom-4">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="saveSetlistBtn">
                    <i class="material-symbols-rounded align-middle me-1">save</i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
    }

    .sortable-setlist .list-group-item {
        cursor: grab;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .75rem;
        font-size: 14px;
    }
</style>