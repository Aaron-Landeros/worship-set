 <div class="col-12 col-md-6 col-lg-4">
     <div class="card user-card shadow-sm h-100">
         <div class="card-body d-flex align-items-center">
             <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name']) ?>&background=random&size=64&rounded=true"
                 class="rounded-circle me-3 flex-shrink-0" width="48" height="48" alt="<?= htmlspecialchars($user['name']) ?>">

             <div class="flex-grow-1">
                 <div class="fw-semibold fs-6 mb-1"><?= htmlspecialchars($user['name']) ?></div>
                 <div class="text-muted small mb-1"><?= htmlspecialchars($user['email']) ?></div>

                 <?php if (!empty($user['team_name'])): ?>
                     <div class="small mb-2">
                         <i class="fas fa-users text-primary me-1"></i>
                         <?= htmlspecialchars($user['team_name']) ?>
                         <?php if ($user['is_leader']): ?>
                             <span class="badge bg-primary ms-2"><?= htmlspecialchars($user['position']) ?></span>
                         <?php endif; ?>
                     </div>
                 <?php else: ?>
                     <div class="text-muted small mb-2">
                         <i class="fas fa-user-slash me-1"></i> No team
                     </div>
                 <?php endif; ?>

                 <div class="d-flex justify-content-between align-items-center small">
                     <span class="text-muted">
                         Joined: <?= date('M j, Y', strtotime($user['created_at'])) ?>
                     </span>

                     <?php if ($user['status'] === 'active'): ?>
                         <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                             <i class="fas fa-check-circle me-1"></i> Available
                         </span>
                     <?php elseif ($user['status'] === 'pause'): ?>
                         <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 rounded-pill">
                             <i class="fas fa-pause-circle me-1"></i> On pause
                         </span>
                     <?php else: ?>
                         <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill">
                             <i class="fas fa-times-circle me-1"></i> Busy
                         </span>
                     <?php endif; ?>
                 </div>

             </div>
         </div>
     </div>
 </div>