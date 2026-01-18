<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OnlineMarketBD • Seller Dashboard</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Seller Dashboard — prefixed to avoid conflicts */
        .sd-body {
            background: #f6f8fb;
            font-family: "Trebuchet MS", Arial, sans-serif;
        }

        .sd-navbar {
            background: #ffffff;
        }

        .sd-brand {
            letter-spacing: .2px;
        }

        .sd-shop-pill {
            font-size: 13px;
            padding: 6px 10px;
            border-radius: 999px;
            background: #111;
            color: #fff;
        }

        .sd-title {
            font-size: 28px;
            font-weight: 800;
            color: #111;
            line-height: 1.1;
        }

        .sd-subtitle {
            color: #566;
            margin-top: 6px;
        }

        .sd-btn {
            border-radius: 12px;
        }

        .sd-card {
            background: #fff;
            border: 1px solid #e9eef6;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
            height: 100%;
        }

        .sd-card-label {
            font-size: 12px;
            color: #667;
            font-weight: 700;
            letter-spacing: .3px;
            text-transform: uppercase;
        }

        .sd-card-value {
            font-size: 28px;
            font-weight: 900;
            color: #111;
            margin-top: 8px;
        }

        .sd-card-hint {
            font-size: 13px;
            color: #778;
            margin-top: 6px;
        }

        .sd-section {
            background: #fff;
            border: 1px solid #e9eef6;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }

        .sd-section-title {
            font-size: 18px;
            font-weight: 900;
            color: #111;
        }

        .sd-section-sub {
            font-size: 13px;
            color: #667;
        }

        .sd-table-wrap {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #eef2f8;
        }

        .sd-table thead th {
            background: #f7f9fc;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .3px;
            color: #667;
            border-bottom: 1px solid #eef2f8;
        }

        .sd-table tbody td {
            border-bottom: 1px solid #f0f3f9;
        }

        .sd-badge {
            display: inline-block;
            padding: 6px 10px;
            font-size: 12px;
            border-radius: 999px;
            font-weight: 800;
            background: #eef2ff;
            color: #3730a3;
        }

        /* a few common statuses */
        .sd-badge-pending,
        .sd-badge-processing,
        .sd-badge-unpaid {
            background: #fff7ed;
            color: #9a3412;
        }

        .sd-badge-paid,
        .sd-badge-completed,
        .sd-badge-delivered {
            background: #ecfdf5;
            color: #065f46;
        }

        .sd-badge-cancelled,
        .sd-badge-canceled,
        .sd-badge-failed {
            background: #fef2f2;
            color: #991b1b;
        }

        .sd-tip {
            background: #111;
            color: #fff;
            border-radius: 16px;
            padding: 16px;
        }

        .sd-tip-title {
            font-weight: 900;
            font-size: 14px;
            letter-spacing: .2px;
        }

        .sd-tip-text {
            margin-top: 6px;
            color: rgba(255, 255, 255, .8);
            font-size: 13px;
        }

        @media (max-width: 576px) {
            .sd-title {
                font-size: 22px;
            }

            .sd-card-value {
                font-size: 24px;
            }
        }
    </style>
</head>

<body class="sd-body">

    <nav class="navbar navbar-expand-lg sd-navbar border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold sd-brand" href="#">
                OnlineMarketBD • Seller Panel
            </a>

            <div class="ms-auto d-flex align-items-center gap-2">
                <span class="sd-shop-pill">
                    {{ $shop->shop_name ?? 'My Shop' }}
                </span>

                <a class="btn btn-sm btn-outline-dark" href="{{ url('/') }}">View Site</a>

                <!-- Logout -->
                <form action="{{ route('seller.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-dark">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-4">

        <div
            class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3 mb-3">
            <div>
                <div class="sd-title">Dashboard</div>
                <div class="sd-subtitle">
                    Welcome back, <strong>{{ auth()->user()->name ?? 'Seller' }}</strong> — here’s what’s happening
                    today.
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <!-- update these URLs to your real seller routes -->
                <a class="btn btn-dark sd-btn" href="{{ route('products.create') }}">+ Add Product</a>
                <a class="btn btn-outline-dark sd-btn" href="#">Manage Orders</a>
                <a class="btn btn-outline-secondary sd-btn" href="#">Shop Settings</a>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="sd-card">
                    <div class="sd-card-label">Today’s Orders</div>
                    <div class="sd-card-value">{{ (int) ($stats['orders_today'] ?? 0) }}</div>
                    <div class="sd-card-hint">Orders placed today</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sd-card">
                    <div class="sd-card-label">Total Orders</div>
                    <div class="sd-card-value">{{ (int) ($stats['orders_total'] ?? 0) }}</div>
                    <div class="sd-card-hint">All-time</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sd-card">
                    <div class="sd-card-label">Pending Orders</div>
                    <div class="sd-card-value">{{ (int) ($stats['orders_pending'] ?? 0) }}</div>
                    <div class="sd-card-hint">Needs attention</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sd-card">
                    <div class="sd-card-label">Today’s Revenue</div>
                    <div class="sd-card-value">৳ {{ number_format((float) ($stats['revenue_today'] ?? 0), 0) }}</div>
                    <div class="sd-card-hint">Calculated from orders</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sd-card">
                    <div class="sd-card-label">Total Revenue</div>
                    <div class="sd-card-value">৳ {{ number_format((float) ($stats['revenue_total'] ?? 0), 0) }}</div>
                    <div class="sd-card-hint">All-time</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sd-card">
                    <div class="sd-card-label">Products</div>
                    <div class="sd-card-value">{{ (int) ($stats['products_total'] ?? 0) }}</div>
                    <div class="sd-card-hint">Active listings</div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="sd-section">
            <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                <div>
                    <div class="sd-section-title">Recent Orders</div>
                    <div class="sd-section-sub">Latest 10 orders for your shop</div>
                </div>
                <a class="btn btn-sm btn-outline-dark" href="#">View All</a>
            </div>

            <div class="table-responsive sd-table-wrap">
                <table class="table align-middle mb-0 sd-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-end">Amount</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $o)
                            @php
                                $amount =
                                    $orderTotalCol && isset($o->{$orderTotalCol}) ? (float) $o->{$orderTotalCol} : 0;
                                $status =
                                    $orderStatusCol && isset($o->{$orderStatusCol})
                                        ? (string) $o->{$orderStatusCol}
                                        : '—';
                            @endphp
                            <tr>
                                <td class="fw-semibold">#{{ $o->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($o->created_at)->format('d M Y, h:i A') }}</td>
                                <td>
                                    <span
                                        class="sd-badge sd-badge-{{ strtolower(preg_replace('/\s+/', '-', $status)) }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="text-end fw-semibold">৳ {{ number_format($amount, 0) }}</td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-dark"
                                        href="{{ route('seller.orders.show', $o->id) ?? '#' }}">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No orders found yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Tips -->
        <div class="sd-tip mt-4">
            <div class="sd-tip-title">Pro tip</div>
            <div class="sd-tip-text">
                Add 5–10 products with clear photos + correct price (BDT) — conversion improves fast when your catalog
                looks “real”.
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
