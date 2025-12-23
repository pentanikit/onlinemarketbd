<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Directory Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --sidebar-width: 260px;
      --topbar-height: 64px;
    }

    body {
      background-color: #f5f6fa;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    /* Topbar */
    .topbar {
      height: var(--topbar-height);
    }

    /* Sidebar */
    .sidebar {
      width: var(--sidebar-width);
    }

    /* Desktop layout: fixed sidebar + content padding */
    @media (min-width: 992px) {
      .sidebar.offcanvas-lg {
        position: fixed;
        top: var(--topbar-height);
        left: 0;
        height: calc(100vh - var(--topbar-height));
        transform: none !important;
        visibility: visible !important;
        border-right: 1px solid #e2e5ec;
        background: #fff;
      }

      .sidebar .offcanvas-header {
        display: none !important;
      }

      .main-content {
        padding-top: calc(var(--topbar-height) + 16px);
        padding-left: calc(var(--sidebar-width) + 16px);
        padding-right: 16px;
      }
    }

    /* Mobile layout: content only needs top padding */
    @media (max-width: 991.98px) {
      .main-content {
        padding-top: calc(var(--topbar-height) + 16px);
        padding-left: 12px;
        padding-right: 12px;
      }
    }

    /* Sidebar links */
    .sidebar-logo {
      font-weight: 700;
      letter-spacing: 0.05em;
    }

    .sidebar .nav-link {
      display: flex;
      align-items: center;
      gap: .55rem;
      font-size: .95rem;
      padding: .55rem .75rem;
      border-radius: .6rem;
      color: #495057;
    }

    .sidebar .nav-link i {
      font-size: 1.1rem;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background: #0d6efd10;
      color: #0d6efd;
    }

    /* Cards */
    .stat-card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 .35rem 1rem rgba(0, 0, 0, 0.04);
    }

    .stat-icon {
      width: 44px;
      height: 44px;
      border-radius: .9rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: #0d6efd10;
    }

    .badge-status {
      font-size: .7rem;
      text-transform: uppercase;
      letter-spacing: .05em;
    }

    .table thead th {
      font-size: .75rem;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: #868e96;
      border-bottom-width: 1px;
      white-space: nowrap;
    }

    .table td {
      vertical-align: middle;
      font-size: .9rem;
    }

    .filter-chip {
      border-radius: 999px;
      font-size: .8rem;
    }

    .app-footer {
      font-size: .8rem;
      color: #868e96;
      padding: 1rem 0;
      margin-top: 1rem;
    }
  </style>
</head>

<body>

  <!-- Top Navbar -->
<x-backend.navbar />

  <!-- Sidebar (Offcanvas on mobile, Fixed on desktop via CSS above) -->
<x-backend.sidebar />

  @yield('admin')



  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.getElementById('yearSpan').textContent = new Date().getFullYear();

    document.getElementById('refreshActivityBtn').addEventListener('click', function () {
      const activityList = document.getElementById('activityList');
      const li = document.createElement('li');
      li.className = 'mb-2 d-flex';
      li.innerHTML = `
        <span class="me-2 text-primary"><i class="bi bi-check2-circle"></i></span>
        <div>System scan: <strong>No critical issues found</strong><div class="text-muted">Just now</div></div>
      `;
      activityList.prepend(li);
    });
  </script>

</body>

</html>
