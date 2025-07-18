<div class="container-fluid py-4 px-3">
    <div class="song-header mb-4">
        <div class="row g-3 align-items-center">

            <!-- Título -->
            <div class="col-12 col-lg-4">
                <h2 class="fw-bold text-primary mb-1 d-flex align-items-center">
                    <i class="material-symbols-rounded me-2" style="font-size:32px;">library_music</i>
                    Song Library
                </h2>
                <p class="text-muted mb-0" style="font-size: 14px;">Manage and organize your worship songs</p>
            </div>

            <!-- Buscador -->
            <div class="col-12 col-lg-4">
                <div class="input-group rounded-pill shadow-sm">
                    <span class="input-group-text bg-white border-0">
                        <i class="material-symbols-rounded text-muted">search</i>
                    </span>
                    <input type="text" id="searchSongs" class="form-control border-0" placeholder="Search songs...">
                </div>
            </div>

            <!-- Filtros -->
            <div class="col-6 col-lg-2">
                <select class="form-select form-select-sm rounded-pill" id="filterKey">
                    <option value="">All Keys</option>
                    <option>C</option>
                    <option>D</option>
                    <option>E</option>
                    <option>F</option>
                </select>
            </div>
            <div class="col-6 col-lg-2">
                <select class="form-select form-select-sm rounded-pill" id="filterBpm">
                    <option value="">All BPM</option>
                    <option>60-80</option>
                    <option>81-100</option>
                    <option>101-120</option>
                </select>
            </div>

            <!-- Botón -->
            <div class="col-12 col-lg-auto text-lg-end">
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <button class="btn btn-primary rounded-pill px-4 w-100 w-md-auto" id="btn_add_song" data-bs-toggle="modal" data-bs-target="#songFormModal">
                        <i class="material-symbols-rounded align-middle">add</i> Add Song
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <style>
        .song-header h2 {
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .song-header {
                padding: 0 10px;
            }

            .song-header h2 {
                font-size: 20px;
            }

            .song-header .btn-primary {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>

    <div class="row g-3" id="songsGrid">
        <?php
        foreach ($songs as $song):
            include '../components/card/song_card.php';
        endforeach;
        ?>
    </div>

    <style>
        .song-card {
            background: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .song-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, .15);
        }

        .song-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .song-card:hover .song-overlay {
            opacity: 1;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            font-size: 18px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

</div>