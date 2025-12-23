  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top topbar">
    <div class="container-fluid">

      <!-- Mobile: open offcanvas -->
      <button class="btn btn-outline-secondary d-lg-none me-2" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
        <i class="bi bi-list"></i>
      </button>

      <a class="navbar-brand d-flex align-items-center gap-2" href="#">
        <i class="bi bi-geo-alt-fill text-primary"></i>
        <span class="fw-bold">Directory Admin</span>
      </a>

      <div class="ms-auto d-flex align-items-center gap-2">
        <form class="d-none d-md-flex">
          <div class="input-group input-group-sm">
            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
            <input type="search" class="form-control border-0 bg-light" placeholder="Search listings...">
          </div>
        </form>

        <button class="btn btn-link text-muted position-relative">
          <i class="bi bi-bell"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
        </button>

        <div class="dropdown">
          <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button"
            id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="me-2">Admin</span>
            <i class="bi bi-person-circle fs-5"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Logout</a></li>
          </ul>
        </div>
      </div>

    </div>
  </nav>