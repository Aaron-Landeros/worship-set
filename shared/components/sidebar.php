<!-- Botón para móviles -->
<button class="sidebar-menu-button">
    <span class="material-symbols-rounded">menu</span>
</button>

<aside class="sidebar">
    <!-- Encabezado -->
    <header class="sidebar-header">
        <a href="#" class="header-logo">
            <img src="assets/entheo_yms_logo.svg" alt="Logo" />
        </a>
        <button class="sidebar-toggler">
            <span class="material-symbols-rounded">chevron_left</span>
        </button>
    </header>

    <nav class="sidebar-nav">
        <!-- Menú principal -->
        <ul class="nav-list primary-nav">

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="material-symbols-rounded">dashboard</span>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>

            <li class="nav-item" id="fetch_users">
                <a href="#" class="nav-link">
                    <span class="material-symbols-rounded">group</span>
                    <span class="nav-label">Members</span>
                </a>
            </li>

            <li class="nav-item" id="fetch_teams">
                <a href="#" class="nav-link">
                    <span class="material-symbols-rounded">diversity_3</span>
                    <span class="nav-label">Teams</span>
                </a>
            </li>

            <!-- Dropdown -->
            <li class="nav-item">
                <a href="#" class="nav-link" id="fetch_services">
                    <span class="material-symbols-rounded">church</span>
                    <span class="nav-label">Services</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="material-symbols-rounded">event</span>
                    <span class="nav-label">Events</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="material-symbols-rounded">music_note</span>
                    <span class="nav-label">Songs</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="material-symbols-rounded">folder</span>
                    <span class="nav-label">Files</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="material-symbols-rounded">settings</span>
                    <span class="nav-label">Settings</span>
                </a>
            </li>
        </ul>

        <!-- Menú secundario -->
        <ul class="nav-list secondary-nav">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="material-symbols-rounded">logout</span>
                    <span class="nav-label">Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>