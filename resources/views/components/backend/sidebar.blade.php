  <div class="offcanvas-lg offcanvas-start sidebar" tabindex="-1" id="sidebarOffcanvas"
      aria-labelledby="sidebarOffcanvasLabel">
      <div class="offcanvas-header border-bottom">
          <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">
              <i class="bi bi-geo-alt-fill text-primary me-1"></i>Directory Admin
          </h5>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <div class="offcanvas-body d-flex flex-column px-3 px-lg-4 pt-3">

          <div class="d-none d-lg-flex align-items-center mb-4">
              <span class="sidebar-logo text-primary">
                  <i class="bi bi-compass-fill me-2"></i>Listing Panel
              </span>
          </div>

          @php
              // Route-based active helper (works with route names)
              $isActive = function ($patterns) {
                  return request()->routeIs($patterns) ? 'active' : '';
              };
          @endphp

          <ul class="nav nav-pills flex-column mb-auto">
              <li class="nav-item mb-1">
                  <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $isActive('admin.dashboard') }}">
                      <i class="bi bi-speedometer2"></i><span>Dashboard</span>
                  </a>
              </li>

              <li class="nav-item mb-1">
                  <a href="{{ route('admin.listing') }}"
                      class="nav-link {{ $isActive(['admin.listing', 'admin.listing.*']) }}">
                      <i class="bi bi-building"></i><span>All Listings</span>
                  </a>
              </li>

              <li class="nav-item mb-1">
                  <a href="{{ route('listings.pending') }}"
                      class="nav-link {{ $isActive(['listings.pending', 'listings.pending.*']) }}">
                      <i class="bi bi-hourglass-split"></i><span>Pending Approval</span>
                  </a>
              </li>

              <li class="nav-item mb-1">
                  <a href="{{ route('home_content.edit') }}"
                      class="nav-link {{ $isActive(['home_content.edit', 'home_content.*']) }}">
                      <i class="bi bi-file-earmark-text"></i><span>Site Content</span>
                  </a>
              </li>

              <li class="nav-item mb-1">
                  <a href="{{ route('categories.index') }}"
                      class="nav-link {{ $isActive(['categories.index', 'categories.*']) }}">
                      <i class="bi bi-tags"></i><span>Categories</span>
                  </a>
              </li>

              <li class="nav-item mb-1">
                  <a href="#" class="nav-link">
                      <i class="bi bi-geo"></i><span>Locations</span>
                  </a>
              </li>

              <li class="nav-item mb-1">
                  <a href="#" class="nav-link">
                      <i class="bi bi-people"></i><span>Users & Owners</span>
                  </a>
              </li>

              <li class="nav-item mb-1">
                  <a href="#" class="nav-link">
                      <i class="bi bi-chat-dots"></i><span>Reviews</span>
                  </a>
              </li>

              <li class="nav-item mb-1">
                  <a href="#" class="nav-link">
                      <i class="bi bi-gear"></i><span>Site Settings</span>
                  </a>
              </li>
          </ul>


          <div class="mt-4 p-3 rounded-3 bg-light border small">
              <div class="fw-semibold mb-1">Quick Tip</div>
              <p class="mb-2">Use filters to find listings that need action fast.</p>
              <button class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addListingModal">
                  <i class="bi bi-plus-lg me-1"></i> Add New Listing
              </button>
          </div>

          <div class="mt-3 small text-muted">
              v1.0 • Directory Admin Template
          </div>
      </div>
  </div>

  <script>
      document.addEventListener('click', function(e) {
          const link = e.target.closest('.sidebar .nav-link');
          if (!link) return;

          // remove old active
          document.querySelectorAll('.sidebar .nav-link.active').forEach(a => a.classList.remove('active'));

          // set active
          link.classList.add('active');
      });
  </script>
