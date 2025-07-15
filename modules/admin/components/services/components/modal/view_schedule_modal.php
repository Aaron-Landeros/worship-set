<div class="modal fade" id="viewScheduleModal" tabindex="-1" aria-labelledby="viewScheduleLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg">
            <!-- Header -->
            <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="viewScheduleLabel">
                    Full Schedule for <?= htmlspecialchars($service['title']) ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <?php if (!empty($segments)): ?>
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Start</th>
                                <th>Duration</th>
                                <th>Segment</th>
                                <th>Description</th>
                                <th>Team</th>
                                <th>Leader / Assignments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($segments as $segment): ?>
                                <tr>
                                    <td><?= $segment['start_time'] ? date('g:i A', strtotime($segment['start_time'])) : '—' ?></td>
                                    <td><?= $segment['duration_minutes'] ? $segment['duration_minutes'] . ' min' : '—' ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($segment['title']) ?></td>
                                    <td><?= htmlspecialchars($segment['description'] ?? '') ?></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($segment['team_name'] ?? 'N/A') ?></span></td>
                                    <td>
                                        <?php if (!empty($segment['leader_name'])): ?>
                                            <strong><?= htmlspecialchars($segment['leader_name']) ?></strong>
                                        <?php endif; ?>
                                        <?php if (!empty($segment['assignments'])): ?>
                                            <ul class="mb-0 small">
                                                <?php foreach ($segment['assignments'] as $assignment): ?>
                                                    <li><?= htmlspecialchars($assignment['user_name']) ?> (<?= htmlspecialchars($assignment['role']) ?>)</li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="text-center text-muted p-4">
                        <i class="material-symbols-rounded mb-2" style="font-size: 2rem;">info</i><br>
                        No segments available yet.
                    </div>
                <?php endif; ?>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>