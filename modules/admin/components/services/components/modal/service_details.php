<div class="container py-4">
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2 class="fw-bold"><?= htmlspecialchars($service['title']) ?></h2>
            <p class="text-muted mb-1">Service Date: <strong><?= date('F j, Y', strtotime($service['service_date'])) ?></strong></p>
            <p class="text-muted">Time: <strong><?= date('g:i A', strtotime($service['start_time'])) ?></strong></p>
        </div>

        <div class="d-flex gap-2">
            <?php if ($is_admin): ?>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSegmentModal">
                    <i class="material-symbols-rounded align-middle">add</i> Add Segment
                </button>
            <?php endif; ?>

            <!-- Nuevo botón para ver el Schedule -->
            <button class="btn btn-outline-dark" id="btn_view_schedule" data-service-id="<?= $service['id'] ?>">
                <i class="material-symbols-rounded align-middle">schedule</i> View Schedule
            </button>
        </div>
    </div>


    <!-- Lista de Segmentos -->
    <h4 class="fw-bold mb-3">Order of Service</h4>

    <?php if (empty($segments)): ?>
        <div class="alert alert-light text-center shadow-sm p-4">
            <i class="material-symbols-rounded text-primary" style="font-size: 2rem;">info</i><br>
            <span class="fw-semibold">No segments have been added yet.</span>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($segments as $segment): ?>
                <!-- Card de Segmento -->
                <div class="col-12 col-md-6">
                    <div class="card border-0 shadow-sm h-100 segment-card" style="background: linear-gradient(135deg, #f9f9f9, #ffffff);">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <!-- Encabezado -->
                            <div>
                                <h5 class="fw-bold text-primary mb-2">
                                    <?= htmlspecialchars($segment['title']) ?>
                                </h5>
                                <p class="text-muted small mb-2">
                                    <?= $segment['start_time'] ? date('g:i A', strtotime($segment['start_time'])) : '—' ?>
                                    <?= $segment['duration_minutes'] ? ' (' . $segment['duration_minutes'] . ' min)' : '' ?>
                                </p>

                                <!-- Descripción -->
                                <?php if (!empty($segment['description'])): ?>
                                    <p class="text-muted small"><?= nl2br(htmlspecialchars($segment['description'])) ?></p>
                                <?php endif; ?>

                                <!-- Team y Líder -->
                                <div class="mb-2">
                                    <span class="badge bg-secondary px-3 py-1"><?= htmlspecialchars($segment['team_name'] ?? 'No Team') ?></span>
                                    <?php if (!empty($segment['leader_name'])): ?>
                                        <div class="text-muted small mt-1">
                                            Leader: <strong><?= htmlspecialchars($segment['leader_name']) ?></strong>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Asignaciones -->
                                <?php if (!empty($segment['assignments'])): ?>
                                    <div class="mt-2">
                                        <small class="text-muted fw-bold">Assignments:</small>
                                        <ul class="ps-3 mb-0">
                                            <?php foreach ($segment['assignments'] as $assignment): ?>
                                                <li class="small"><?= htmlspecialchars($assignment['user_name']) ?> — <em><?= htmlspecialchars($assignment['role']) ?></em></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <!-- Contenido Extra -->
                                <?php if (!empty($segment['extra_contents'])): ?>
                                    <div class="mt-3">
                                        <small class="text-muted fw-bold">Team Content:</small>
                                        <ul class="ps-3 mb-0">
                                            <?php foreach ($segment['extra_contents'] as $content): ?>
                                                <li class="small">
                                                    <strong><?= ucfirst($content['content_type']) ?>:</strong>
                                                    <?= nl2br(htmlspecialchars($content['content'])) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <?php
                                $segment_team_id = $segment['team_id'];
                                $leader_teams = $_SESSION['leader_teams'] ?? [];
                                $can_edit = $is_admin || in_array($segment_team_id, array_column($leader_teams, 'team_id'));
                                ?>
                                <?php if ($can_edit): ?>
                                    <button class="btn btn-sm btn-primary d-flex align-items-center gap-1 rounded-pill px-3"
                                        data-segment-id="<?= $segment['id'] ?>">
                                        <span class="material-symbols-rounded" style="font-size:18px;">edit</span>
                                        Edit
                                    </button>
                                    <button class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1 rounded-pill px-3"
                                        data-segment-id="<?= $segment['id'] ?>">
                                        <span class="material-symbols-rounded" style="font-size:18px;">note_add</span>
                                        Fill Content
                                    </button>

                                <?php endif; ?>
                                <?php if ($segment['team_name'] === 'Worship Team' && $can_edit): ?>
                                    <button class="btn btn-sm btn-primary mt-2" id="btn_manage_setlist" data-service-id="<?= $segment['service_id'] ?>" data-segment-id="<?= $segment['id'] ?>">
                                        <i class="material-symbols-rounded align-middle">music_note</i> Manage Setlist
                                    </button>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .segment-card {
        border-radius: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .segment-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1);
    }

    .badge {
        font-size: 0.8rem;
    }

    .btn-sm {
        font-size: 14px;
        border-radius: 50px;
    }
</style>

