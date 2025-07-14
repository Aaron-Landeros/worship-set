<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="fw-bold display-5 mb-1">Members</h1>
            <p class="text-muted fs-5 mb-0">Manage the people in your church – leaders, members, and roles.</p>
        </div>

        <div class="d-flex align-items-center gap-2 ms-auto">
            <button class="btn btn-outline-secondary">Export</button>
            <button class="btn btn-primary">
                <i class="fas fa-user-plus me-1"></i> Add User
            </button>
        </div>
    </div>


    <div class="row g-3">
        <?php 
            foreach ($users as $user):
                include 'components/card/user_card.php';
            endforeach; 
        ?>
    </div>
</div>