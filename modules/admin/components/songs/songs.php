<div class="container-fluid py-4 px-3">

    <!-- HEADER -->
    <div class="song-header bg-white rounded-4 shadow-sm p-4 mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">

            <!-- Título -->
            <div>
                <h2 class="fw-bold text-primary mb-1 d-flex align-items-center">
                    <i class="material-symbols-rounded me-2" style="font-size:32px;">library_music</i>
                    Song Library
                </h2>
                <p class="text-muted mb-0" style="font-size: 14px;">Manage and organize your worship songs</p>
            </div>

            <!-- Acciones y Filtros -->
            <div class="d-flex flex-wrap align-items-center gap-3 justify-content-lg-end">

                <!-- Search -->
                <div class="input-group rounded-pill shadow-sm" style="max-width: 280px;">
                    <span class="input-group-text bg-white border-0">
                        <i class="material-symbols-rounded text-muted">search</i>
                    </span>
                    <input type="text" id="searchSongs" class="form-control border-0" placeholder="Search songs...">
                </div>

                <!-- Filters -->
                <select class="form-select form-select-sm rounded-pill px-3" id="filterKey">
                    <option value="">All Keys</option>
                    <option>C</option>
                    <option>D</option>
                    <option>E</option>
                    <option>F</option>
                </select>
                <select class="form-select form-select-sm rounded-pill px-3" id="filterBpm">
                    <option value="">All BPM</option>
                    <option>60-80</option>
                    <option>81-100</option>
                    <option>101-120</option>
                </select>

                <!-- Toggle View -->
                <div class="btn-group rounded-pill overflow-hidden shadow-sm">
                    <button class="btn btn-light active" id="toggleGrid" title="Grid View">
                        <i class="material-symbols-rounded">grid_view</i>
                    </button>
                    <button class="btn btn-light" id="toggleList" title="List View">
                        <i class="material-symbols-rounded">view_list</i>
                    </button>
                </div>

                <!-- Add Song Button -->
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <button class="btn btn-primary rounded-pill px-4 d-flex align-items-center gap-1" id="btnAddSong">
                        <i class="material-symbols-rounded">add</i> Add Song
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- CSS -->
    <style>
        .song-header {
            border: 1px solid #f1f3f4;
        }

        .btn-primary {
            background-color: #4a6cf7;
            border: none;
            font-weight: 500;
            transition: 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3d5ed7;
        }

        .btn-group .btn-light.active {
            background-color: #f1f1f1;
        }

        .input-group input:focus {
            box-shadow: none;
        }

        .form-select {
            border-radius: 50px;
        }
    </style>


    <!-- GRID -->
    <div class="row g-4" id="songsGrid">
        <?php foreach ($songs as $song): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="song-card shadow-sm rounded-4 overflow-hidden position-relative">

                    <!-- Imagen con Overlay -->
                    <div class="position-relative">
                        <div class="ratio ratio-1x1">
                            <img src="<?= $song['album_art_url'] ?: 'https://via.placeholder.com/400x400?text=Album' ?>"
                                class="img-fluid w-100 h-100 object-fit-cover" alt="Album Art">
                        </div>

                        <!-- Overlay con acciones -->
                        <div class="song-overlay d-flex justify-content-center align-items-center gap-2">
                            <button class="btn btn-light btn-icon view-song" data-song-id="<?= $song['id'] ?>" title="View Details">
                                <i class="material-symbols-rounded">visibility</i>
                            </button>
                            <button class="btn btn-primary btn-icon add-to-setlist" data-song-id="<?= $song['id'] ?>" title="Add to Setlist">
                                <i class="material-symbols-rounded">queue_music</i>
                            </button>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <button class="btn btn-dark btn-icon edit-song" data-song-id="<?= $song['id'] ?>" title="Edit Song">
                                    <i class="material-symbols-rounded">edit</i>
                                </button>
                            <?php endif; ?>
                            <button class="btn btn-light btn-icon favorite-song" title="Add to Favorites">
                                <i class="material-symbols-rounded">favorite</i>
                            </button>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="p-3">
                        <h6 class="fw-bold text-truncate mb-1"><?= htmlspecialchars($song['title']) ?></h6>
                        <p class="text-muted small mb-2 text-truncate"><?= htmlspecialchars($song['artist']) ?></p>
                        <div class="d-flex justify-content-between align-items-center text-muted small">
                            <span><i class="material-symbols-rounded align-middle me-1">music_note</i><?= $song['key_signature'] ?: '-' ?></span>
                            <span><i class="material-symbols-rounded align-middle me-1">speed</i><?= $song['bpm'] ?: '-' ?> BPM</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- CSS -->
    <style>
        .song-card {
            background: #fff;
            border-radius: 16px;
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .song-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 18px rgba(0, 0, 0, 0.15);
        }

        .song-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(6px);
            opacity: 0;
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease;
        }

        .song-card:hover .song-overlay {
            opacity: 1;
        }

        .btn-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }

        .btn-icon i {
            font-size: 20px;
        }
    </style>

</div>