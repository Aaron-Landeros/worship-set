<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold">Services</h1>
            <p class="text-muted mb-0">View and manage upcoming services.</p>
        </div>
        <button class="btn btn-primary" id="create_service">
            <span class="material-symbols-rounded align-middle me-1">add_circle</span> New Service
        </button>
    </div>

    <div id="services_list" class="row g-4">
        <?php if (!empty($services)): ?>
            <?php foreach ($services as $service): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-between h-100">
                            <div class="mb-3">
                                <h5 class="card-title fw-bold text-primary"><?= htmlspecialchars($service['title']) ?></h5>
                                <p class="text-muted small mb-1">
                                    <span class="material-symbols-rounded align-middle me-1">event</span>
                                    <?= date('F j, Y', strtotime($service['service_date'])) ?>
                                </p>
                                <p class="text-muted small mb-0">
                                    <span class="material-symbols-rounded align-middle me-1">schedule</span>
                                    <?= date('g:i A', strtotime($service['start_time'])) ?>
                                </p>
                            </div>
                            <div class="mt-auto text-end">
                                <button data-service-id="<?= $service['id'] ?>" class="btn_view_service btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-secondary text-center">No services scheduled yet.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
