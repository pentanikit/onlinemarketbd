@extends('backend.layout')
@section('admin')
      <!-- Main Content -->
  <main class="main-content">
    <div class="container-fluid py-2">

      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
        <div>
          <h4 class="mb-1">Dashboard Overview</h4>
          <p class="mb-0 text-muted small">Monitor listings, approvals, and activity.</p>
        </div>
        <div class="mt-2 mt-md-0 d-flex gap-2">
          <button class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-download me-1"></i>Export
          </button>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addListingModal">
            <i class="bi bi-plus-lg me-1"></i>New Listing
          </button>
        </div>
      </div>

      <div class="row g-3 mb-3">
        <div class="col-6 col-md-3">
          <div class="card stat-card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <small class="text-muted text-uppercase fw-semibold">Total Listings</small>
                  <h5 class="mt-1 mb-0">1,248</h5>
                  <span class="text-success small"><i class="bi bi-arrow-up-right"></i> +4.2%</span>
                </div>
                <div class="stat-icon text-primary"><i class="bi bi-building"></i></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card stat-card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <small class="text-muted text-uppercase fw-semibold">Pending</small>
                  <h5 class="mt-1 mb-0">37</h5>
                  <span class="text-warning small"><i class="bi bi-hourglass-split"></i> Review now</span>
                </div>
                <div class="stat-icon text-warning"><i class="bi bi-hourglass-top"></i></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card stat-card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <small class="text-muted text-uppercase fw-semibold">Today Views</small>
                  <h5 class="mt-1 mb-0">5,930</h5>
                  <span class="text-success small"><i class="bi bi-graph-up"></i> +12.8%</span>
                </div>
                <div class="stat-icon text-success"><i class="bi bi-bar-chart"></i></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card stat-card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <small class="text-muted text-uppercase fw-semibold">Reported</small>
                  <h5 class="mt-1 mb-0">5</h5>
                  <span class="text-danger small"><i class="bi bi-flag"></i> Needs action</span>
                </div>
                <div class="stat-icon text-danger"><i class="bi bi-flag-fill"></i></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-lg-8">
          <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body">
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-2">
                <h6 class="mb-2 mb-md-0">Recent Listings</h6>
                <div class="d-flex flex-wrap gap-2">
                  <select class="form-select form-select-sm w-auto">
                    <option>All Categories</option>
                    <option>Restaurants</option>
                    <option>Hotels</option>
                    <option>Shops</option>
                    <option>Services</option>
                  </select>
                  <select class="form-select form-select-sm w-auto">
                    <option>Status: All</option>
                    <option>Published</option>
                    <option>Pending</option>
                    <option>Draft</option>
                  </select>
                  <select class="form-select form-select-sm w-auto">
                    <option>Sort: Newest</option>
                    <option>Sort: Oldest</option>
                    <option>Sort: Most viewed</option>
                  </select>
                </div>
              </div>

              <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-light text-dark filter-chip"><i class="bi bi-pin-map me-1"></i>Dhaka</span>
                <span class="badge bg-light text-dark filter-chip"><i class="bi bi-star-half me-1"></i>Rating 4.0+</span>
                <span class="badge bg-light text-dark filter-chip"><i class="bi bi-clock-history me-1"></i>Last 7 days</span>
              </div>

              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Listing</th>
                      <th>Category</th>
                      <th>Location</th>
                      <th>Status</th>
                      <th>Views</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="fw-semibold">Urban Spice Restaurant</div>
                        <div class="text-muted small">Owner: Rahman Foods</div>
                      </td>
                      <td>Restaurant</td>
                      <td>Banani, Dhaka</td>
                      <td><span class="badge bg-success-subtle text-success badge-status border border-success-subtle">Published</span></td>
                      <td>1,230</td>
                      <td class="text-end">
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="fw-semibold">Skyline Grand Hotel</div>
                        <div class="text-muted small">Owner: Skyline Group</div>
                      </td>
                      <td>Hotel</td>
                      <td>Gulshan, Dhaka</td>
                      <td><span class="badge bg-warning-subtle text-warning badge-status border border-warning-subtle">Pending</span></td>
                      <td>890</td>
                      <td class="text-end">
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="fw-semibold">GreenLeaf Super Shop</div>
                        <div class="text-muted small">Owner: GreenLeaf Retail</div>
                      </td>
                      <td>Shop</td>
                      <td>Dhanmondi, Dhaka</td>
                      <td><span class="badge bg-secondary-subtle text-secondary badge-status border border-secondary-subtle">Draft</span></td>
                      <td>410</td>
                      <td class="text-end">
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="fw-semibold">TechFix Service Center</div>
                        <div class="text-muted small">Owner: TechFix BD</div>
                      </td>
                      <td>Service</td>
                      <td>Uttara, Dhaka</td>
                      <td><span class="badge bg-danger-subtle text-danger badge-status border border-danger-subtle">Reported</span></td>
                      <td>640</td>
                      <td class="text-end">
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Showing 1–4 of 25 listings</small>
                <nav>
                  <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-link">Prev</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                  </ul>
                </nav>
              </div>

            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">New Owners</h6>
                <a href="#" class="small text-decoration-none">View all</a>
              </div>

              <div class="list-group list-group-flush">
                <div class="list-group-item px-0 d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2"
                      style="width: 36px; height: 36px;"><span class="fw-semibold">RA</span></div>
                    <div>
                      <div class="fw-semibold small">Rahim Ahmed</div>
                      <div class="text-muted small">Urban Spice Restaurant</div>
                    </div>
                  </div>
                  <span class="badge bg-light text-success border border-success-subtle small">Approved</span>
                </div>

                <div class="list-group-item px-0 d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2"
                      style="width: 36px; height: 36px;"><span class="fw-semibold">NS</span></div>
                    <div>
                      <div class="fw-semibold small">Nusrat Sultana</div>
                      <div class="text-muted small">Skyline Grand Hotel</div>
                    </div>
                  </div>
                  <span class="badge bg-warning-subtle text-warning border border-warning-subtle small">Pending</span>
                </div>

                <div class="list-group-item px-0 d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2"
                      style="width: 36px; height: 36px;"><span class="fw-semibold">MK</span></div>
                    <div>
                      <div class="fw-semibold small">Mahfuz Karim</div>
                      <div class="text-muted small">TechFix Service Center</div>
                    </div>
                  </div>
                  <span class="badge bg-light text-muted border border-secondary-subtle small">New</span>
                </div>
              </div>
            </div>
          </div>

          <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Latest Activity</h6>
                <button class="btn btn-sm btn-outline-secondary" id="refreshActivityBtn">
                  <i class="bi bi-arrow-repeat"></i>
                </button>
              </div>

              <ul class="list-unstyled mb-0 small" id="activityList">
                <li class="mb-2 d-flex">
                  <span class="me-2 text-primary"><i class="bi bi-check-circle"></i></span>
                  <div>Published <strong>Urban Spice Restaurant</strong><div class="text-muted">5 minutes ago</div></div>
                </li>
                <li class="mb-2 d-flex">
                  <span class="me-2 text-warning"><i class="bi bi-hourglass-split"></i></span>
                  <div><strong>Skyline Grand Hotel</strong> moved to pending<div class="text-muted">18 minutes ago</div></div>
                </li>
                <li class="mb-2 d-flex">
                  <span class="me-2 text-danger"><i class="bi bi-flag"></i></span>
                  <div>New report on <strong>TechFix Service Center</strong><div class="text-muted">40 minutes ago</div></div>
                </li>
              </ul>

            </div>
          </div>
        </div>
      </div>

      <div class="app-footer text-center">
        &copy; <span id="yearSpan"></span> Directory Admin • Bootstrap 5
      </div>

    </div>
  </main>
@endsection