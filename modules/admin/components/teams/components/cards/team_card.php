<div class="col-12 col-md-6 col-lg-4">
    <div data-team-id="<?= htmlspecialchars($team['id']) ?>" class="team_card card team-card border-0 shadow-sm position-relative overflow-hidden h-100 p-3">
        <div class="position-absolute top-0 end-0 opacity-10 pe-3 pt-3">
            <i class="fa-solid fa-people-group fa-3x text-light"></i>
        </div>

        <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
            <div class="mb-3">
                <h5 class="fw-bold text-primary mb-1"><?= htmlspecialchars($team['name']) ?></h5>
                <p class="card-text text-muted small mb-0"><?= nl2br(htmlspecialchars($team['description'])) ?></p>
            </div>

            <?php if (!empty($team_leaders)): ?>
                <div class="d-flex gap-1 mt-2">
                    <?php
                    $maxVisible = 2;
                    $visibleLeaders = array_slice($team_leaders, 0, $maxVisible);
                    $remainingCount = count($team_leaders) - $maxVisible;
                    ?>

                    <?php foreach ($visibleLeaders as $leader): ?>
                        <div class="d-flex align-items-center gap-1 mb-1 ps-2 pe-2">
                            <img
                                src="https://ui-avatars.com/api/?name=<?= urlencode($leader['user_name']) ?>&background=random&rounded=true&size=64"
                                alt="Leader Avatar"
                                class="rounded-circle shadow-sm flex-shrink-0"
                                width="28" height="28">
                            <div class="small lh-sm">
                                <div class="text-muted" style="font-size: 11px;"><?= htmlspecialchars($leader['position'] ?? 'Leader') ?></div>
                                <div class="fw-normal" style="font-size: 12px;"><?= htmlspecialchars($leader['user_name']) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if ($remainingCount > 0): ?>
                        <div class="d-flex align-items-center gap-1">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 28px; height: 28px; font-size: 12px;">
                                +<?= $remainingCount ?>
                            </div>
                            <div class="text-muted small" style="font-size: 11px;">More Leader<?= $remainingCount > 1 ? 's' : '' ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="text-muted small mt-auto">
                    <i class="fa-regular fa-circle-question me-1"></i>No assigned leader
                </div>
            <?php endif; ?>


            <div class="mt-3">
                <span class="badge bg-gradient-primary text-white px-3 py-1 small shadow-sm"><?= htmlspecialchars($team['church_name']) ?></span>
            </div>
        </div>
    </div>
</div>