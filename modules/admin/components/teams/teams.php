<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="fw-bold display-5">Service Teams</h1>
        <p class="text-muted fs-5">Discover the active ministries and their leaders.</p>
        </div>

        <div class="d-flex align-items-center gap-2 ms-auto">
            <button class="btn btn-outline-secondary">Export</button>
            <button class="btn btn-primary">
                <i class="fas fa-user-plus me-1"></i> Add Team
            </button>
        </div>
    </div>

    <div class="row g-4">
        <?php
        foreach ($teams as $team):
            $team_id = htmlspecialchars($team['id']);
            $team_leaders = fetch_team_leaders($db, $team_id);

            include 'components/cards/team_card.php';
        endforeach;
        ?>
    </div>
</div>

<style>
    .team-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(245, 245, 255, 0.95));
        border-radius: 1rem;
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1.5rem 3rem rgba(0, 0, 0, 0.1);
    }

    .bg-gradient-primary {
        background: linear-gradient(to right, #6a11cb, #2575fc);
    }

    .opacity-10 {
        opacity: 0.08;
    }
</style>