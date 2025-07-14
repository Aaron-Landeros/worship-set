<div class="container py-4">
    <!-- Encabezado del Servicio -->
    <div class="mb-4">
        <h2 class="fw-bold"><?= htmlspecialchars($service['title']) ?></h2>
        <p class="text-muted mb-1">
            Service Date: <strong><?= date('F j, Y', strtotime($service['service_date'])) ?></strong>
        </p>
        <p class="text-muted">
            Time: <strong><?= date('g:i A', strtotime($service['start_time'])) ?></strong>
        </p>
        <?php if ($is_admin): ?>
            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addSegmentModal">
                <i class="material-symbols-rounded align-middle">add</i> Add Segment
            </button>
        <?php endif; ?>
    </div>

    <!-- Lista de Segmentos -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light fw-semibold">Order of Service</div>

        <?php if (empty($segments)): ?>
            <div class="text-center p-4 text-muted">
                <i class="material-symbols-rounded mb-2" style="font-size: 2rem;">info</i><br>
                No segments have been added yet.
            </div>
        <?php else: ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($segments as $segment): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-start flex-column flex-md-row">
                        <div class="w-100">
                            <!-- Título y hora -->
                            <div class="fw-bold mb-1">
                                <?= $segment['start_time'] ? date('g:i A', strtotime($segment['start_time'])) : '—' ?>
                                <?= $segment['duration_minutes'] ? ' (' . $segment['duration_minutes'] . ' min)' : '' ?>
                                — <?= $segment['title'] ?>
                            </div>

                            <!-- Descripción -->
                            <div class="text-muted small mb-2"><?= $segment['description'] ?? '' ?></div>

                            <!-- Team asignado -->
                            <?php if (!empty($segment['team_name'])): ?>
                                <div class="mb-1">
                                    <span class="badge bg-secondary"><?= $segment['team_name'] ?? '' ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Líder asignado -->
                            <?php if (!empty($segment['leader_name'])): ?>
                                <div class="text-muted small">Leader: <strong><?= $segment['leader_name'] ?? '' ?></strong></div>
                            <?php endif; ?>

                            <!-- Asignaciones -->
                            <?php if (!empty($segment['assignments'])): ?>
                                <div class="mt-2">
                                    <small class="text-muted">Assignments:</small>
                                    <ul class="mb-0 ps-3">
                                        <?php foreach ($segment['assignments'] as $assignment): ?>
                                            <li class="small"><?= $assignment['user_name'] ?> — <em><?= $assignment['role'] ?></em></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <!-- Contenidos del equipo (segment_content) -->
                            <?php if (!empty($segment['extra_contents'])): ?>
                                <div class="mt-3">
                                    <small class="text-muted">Team Content:</small>
                                    <ul class="mb-0 ps-3">
                                        <?php foreach ($segment['extra_contents'] as $content): ?>
                                            <li class="small">
                                                <strong><?= ucfirst($content['content_type']) ?>:</strong>
                                                <?= nl2br($content['content']) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Acciones -->
                        <div class="d-flex flex-column align-items-end mt-3 mt-md-0 ms-md-3">
                            <?php
                            $segment_team_id = $segment['team_id'];
                            $leader_teams = $_SESSION['leader_teams'] ?? [];
                            $can_edit = $is_admin || in_array($segment_team_id, array_column($leader_teams, 'team_id'));
                            ?>
                            <?php if ($can_edit): ?>
                                <button class="btn btn-sm btn-outline-primary mb-2" data-segment-id="<?= $segment['id'] ?>">
                                    <i class="material-symbols-rounded align-middle">edit</i> Edit Segment
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" data-segment-id="<?= $segment['id'] ?>">
                                    <i class="material-symbols-rounded align-middle">note_add</i> Fill Team Content
                                </button>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
