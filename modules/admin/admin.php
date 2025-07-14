<div class="container py-4">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Welcome, <?= $_SESSION['name']; ?></h1>
        <p class="text-muted fs-5">Manage your church teams, events and resources from one place.</p>
    </div>

    <div class="row g-4">

        <div class="col-12 col-md-6 col-lg-4">
            <a class="text-decoration-none" id="fetch_users">
                <div class="card card-gradient-users text-white text-center shadow h-100 transition">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <span class="material-symbols-rounded mb-3">groups</span>
                        <h5 class="card-title fw-bold">Members</h5>
                        <p class="card-text">Manage members and roles.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <a class="text-decoration-none" id="fetch_teams">
                <div class="card card-gradient-teams text-white text-center shadow h-100 transition">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <span class="material-symbols-rounded mb-3">diversity_3</span>
                        <h5 class="card-title fw-bold">Teams</h5>
                        <p class="card-text">Manage service teams.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <a class="text-decoration-none" id="fetch_services">
                <div class="card card-gradient-services text-white text-center shadow h-100 transition">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <span class="material-symbols-rounded mb-3">church</span>
                        <h5 class="card-title fw-bold">Services</h5>
                        <p class="card-text">Plan and schedule services.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <a class="text-decoration-none">
                <div class="card card-gradient-services text-white text-center shadow h-100 transition">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <span class="material-symbols-rounded mb-3">event</span>
                        <h5 class="card-title fw-bold">Events</h5>
                        <p class="card-text">Plan and schedule your events.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <a class="text-decoration-none">
                <div class="card card-gradient-songs text-white text-center shadow h-100 transition">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <span class="material-symbols-rounded mb-3">library_music</span>
                        <h5 class="card-title fw-bold">Songs</h5>
                        <p class="card-text">Your worship song library.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <a class="text-decoration-none">
                <div class="card card-gradient-files text-white text-center shadow h-100 transition">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <span class="material-symbols-rounded mb-3">folder</span>
                        <h5 class="card-title fw-bold">Files</h5>
                        <p class="card-text">Manage uploaded documents.</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>


<style>
    .card {
        border: none;
        border-radius: 1rem;
    }

    .transition {
        transition: all 0.3s ease;
    }

    .transition:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15);
    }

    .card-gradient-users {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
    }

    .card-gradient-teams {
        background: linear-gradient(135deg, #11998e, #38ef7d);
    }

    .card-gradient-services {
        background: linear-gradient(135deg, #f7971e, #ffd200);
    }

    .card-gradient-songs {
        background: linear-gradient(135deg, #43cea2, #185a9d);
    }

    .card-gradient-files {
        background: linear-gradient(135deg, #ff416c, #ff4b2b);
    }
</style>