<div class="modal fade" id="teamDetailsModal" tabindex="-1" aria-labelledby="teamDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen-sm-down modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-0 rounded-lg-4">

      <!-- Header -->
      <div class="modal-header bg-primary text-white rounded-0 rounded-top-lg-4">
        <div>
          <h5 class="modal-title fw-bold mb-0" id="teamDetailsModalLabel">
            <?= htmlspecialchars($team['name']) ?>
          </h5>
          <small class="text-white-50">Team details and members from <?= htmlspecialchars($team['church_name']) ?></small>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Description -->
        <div class="mb-4">
          <h6 class="fw-semibold text-secondary">Description</h6>
          <p class="text-muted mb-0"><?= nl2br(htmlspecialchars($team['description'])) ?: 'No description provided.' ?></p>
        </div>

        <!-- Members -->
        <div>
          <h6 class="fw-semibold text-secondary">Team Members</h6>
          <?php if (!empty($team_members)): ?>
            <ul class="list-group list-group-flush">
              <?php foreach ($team_members as $member): ?>
                <li class="list-group-item d-flex align-items-center justify-content-between flex-wrap">
                  <div class="d-flex align-items-center gap-2">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($member['user_name']) ?>&background=random&rounded=true&size=64"
                      class="rounded-circle shadow-sm"
                      width="40" height="40"
                      alt="<?= htmlspecialchars($member['user_name']) ?>">
                    <div>
                      <div class="fw-semibold"><?= htmlspecialchars($member['user_name']) ?></div>
                      <div class="text-muted small">
                        <?= $member['is_leader'] ? 'Leader' : 'Member' ?>
                      </div>
                    </div>
                  </div>
                  <?php if ($member['is_leader']): ?>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 mt-2 mt-sm-0">
                      <i class="fas fa-star me-1"></i> <?= htmlspecialchars($member['position']) ?>
                    </span>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <div class="text-muted">No members found in this team.</div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</div>