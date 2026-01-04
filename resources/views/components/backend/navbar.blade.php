<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top topbar">
    <div class="container-fluid">

        <!-- Left: Mobile sidebar button + Brand -->
        <div class="d-flex align-items-center gap-2 flex-grow-1 min-w-0">
            <!-- Mobile: open offcanvas -->
            <button class="btn btn-outline-secondary d-lg-none flex-shrink-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                <i class="bi bi-list"></i>
            </button>

            <a class="navbar-brand d-flex align-items-center gap-2 mb-0 min-w-0" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-geo-alt-fill text-primary flex-shrink-0"></i>
                <span class="fw-bold text-truncate topbar-brand-text">Directory Admin</span>
            </a>
        </div>

        <!-- Right: Actions -->
        <div class="d-flex align-items-center gap-2 flex-shrink-0">

            <!-- Mobile: Search toggle button -->
            <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#topbarSearchCollapse" aria-expanded="false" aria-controls="topbarSearchCollapse">
                <i class="bi bi-search"></i>
            </button>

            <!-- Desktop: Search always visible -->
            <form class="d-none d-md-flex">
                <div class="input-group input-group-sm topbar-search">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control border-0 bg-light" placeholder="Search listings...">
                </div>
            </form>

            <button class="btn btn-link text-muted position-relative p-0 topbar-icon-btn" type="button">
                <i class="bi bi-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
            </button>

            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center"
                    type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="me-2 d-none d-sm-inline">Admin</span>
                    <i class="bi bi-person-circle fs-5"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div>

        </div>

    </div>

    <!-- Mobile search (collapsible row under navbar) -->
    <div class="collapse d-md-none border-top bg-white" id="topbarSearchCollapse">
        <div class="container-fluid py-2">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                <input type="search" class="form-control border-0 bg-light" placeholder="Search listings...">
            </div>
        </div>
    </div>
</nav>

<style>
    /* Topbar spacing: fixed-top navbar needs body padding */
    body {
        padding-top: 64px;
    }

    /* Prevent brand from pushing icons off-screen */
    .topbar .min-w-0 {
        min-width: 0;
    }

    .topbar-brand-text {
        max-width: 180px;
    }

    /* Make search not too wide on desktop */
    .topbar-search {
        width: 260px;
    }

    /* Cleaner icon button sizing on mobile */
    .topbar-icon-btn {
        line-height: 1;
    }

    /* Smaller brand text width on very small phones */
    @media (max-width: 375px) {
        .topbar-brand-text {
            max-width: 120px;
        }
    }
</style>
