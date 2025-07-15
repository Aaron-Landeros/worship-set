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
                                    foreach ($setlist as $song):
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
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="material-symbols-rounded me-1">group</i> Assign Musicians & Singers
                        </h6>

                        <!-- Barra de búsqueda -->
                        <div class="d-flex gap-2 mb-3">
                            <input data-church-id="<?= $church_id ?>" type="text" id="musician_search" class="form-control" placeholder="Search musician by name...">
                            <button class="btn btn-primary" id="btnAddMusician" disabled>
                                <i class="material-symbols-rounded align-middle">person_add</i> Add
                            </button>
                        </div>

                        <!-- Resultados de búsqueda -->
                        <div id="searchResults" class="border rounded p-2 mb-3 bg-light" style="max-height: 150px; overflow-y: auto;">
                            <p class="text-muted small text-center mb-0">Start typing to search...</p>
                        </div>

                        <!-- Lista de asignados -->
                        <h6 class="fw-bold text-secondary mt-4 mb-2">Assigned Members</h6>
                        <div class="table-responsive border rounded p-2 bg-white">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Song to Lead</th>
                                        <th>MD</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="assignedMusicians" data-service-id="<?= $service_id ?>" data-segment-id="<?= $segment_id ?>">
                                    <?php if (!empty($assignments)): ?>
                                        <?php foreach ($assignments as $a): ?>
                                            <tr data-user-id="<?= $a['user_id'] ?>">
                                                <!-- Nombre -->
                                                <td><?= htmlspecialchars($a['user_name']) ?></td>

                                                <!-- Rol -->
                                                <td>
                                                    <select class="form-select form-select-sm musician-role">
                                                        <option value="">Select Role</option>
                                                        <option value="Lead Vocal" <?= $a['role'] == 'Lead Vocal' ? 'selected' : '' ?>>Lead Vocal</option>
                                                        <option value="Background Vocal" <?= $a['role'] == 'Background Vocal' ? 'selected' : '' ?>>Background Vocal</option>
                                                        <option value="Guitar" <?= $a['role'] == 'Guitar' ? 'selected' : '' ?>>Guitar</option>
                                                        <option value="Bass" <?= $a['role'] == 'Bass' ? 'selected' : '' ?>>Bass</option>
                                                        <option value="Drums" <?= $a['role'] == 'Drums' ? 'selected' : '' ?>>Drums</option>
                                                        <option value="Keyboard" <?= $a['role'] == 'Keyboard' ? 'selected' : '' ?>>Keyboard</option>
                                                    </select>
                                                </td>

                                                <!-- Canción asignada -->
                                                <td>
                                                    <select class="form-select form-select-sm song-select <?= $a['role'] == 'Lead Vocal' ? '' : 'd-none' ?>">
                                                        <option value="">Choose Song</option>
                                                        <?php foreach ($setlist as $song_item):
                                                            $song_data = fetch_song_data($db, $song_item['song_id']); ?>
                                                            <option value="<?= $song_item['song_id'] ?>" <?= $a['song_id'] == $song_item['song_id'] ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($song_data['title']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>

                                                <!-- Checkbox MD -->
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input md-checkbox" <?= $a['is_md'] ? 'checked' : '' ?>>
                                                </td>

                                                <!-- Botón eliminar -->
                                                <td>
                                                    <button class="btn btn-sm btn-danger btn-remove-member">
                                                        <i class="material-symbols-rounded">delete</i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted small">No musicians assigned yet</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer bg-light rounded-bottom-4">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="btn_save_setlist"
                    data-service-id="<?= $service_id ?>" data-segment-id="<?= $segment_id ?>">
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