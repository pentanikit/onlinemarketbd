@extends('backend.layout')
@section('admin')
@php
    /**
     * Expected from controller:
     * - $listings   => paginated Listing::with(['category','city','user'])->paginate(...)
     * - $categories => Category::orderBy('name')->get()
     * - $cities     => City::orderBy('name')->get()
     *
     * Filters (GET):
     * - q, category_id, status, city_id
     */
    $q          = request('q');
    $categoryId = request('category_id');
    $status     = request('status', 'all');
    $cityId     = request('city_id');

    $statusBadge = function ($st) {
        $st = strtolower((string) $st);

        return match ($st) {
            'published', 'active', 'approved' => ['Published', 'bg-success-subtle text-success border'],
            'pending'                          => ['Pending', 'bg-warning-subtle text-warning border'],
            'draft'                            => ['Draft', 'bg-secondary-subtle text-secondary border'],
            'rejected'                         => ['Rejected', 'bg-danger-subtle text-danger border'],
            default                            => [ucfirst($st ?: 'Unknown'), 'bg-light text-dark border'],
        };
    };
@endphp

<main class="main-content">
    <div class="container-fluid py-2">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
            <div>
                <h4 class="mb-1">All Listings</h4>
                <p class="mb-0 text-muted small">Search, filter, and manage all directory listings.</p>
            </div>
            <div class="d-flex gap-2 mt-2 mt-md-0">
                {{-- Optional: export route --}}
                <a class="btn btn-outline-secondary btn-sm" href="#">
                    <i class="bi bi-download me-1"></i>Export
                </a>

                {{-- Create route --}}
                <a class="btn btn-primary btn-sm" href="{{ route('listings.create') }}">
                    <i class="bi bi-plus-lg me-1"></i>Add Listing
                </a>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.listing') }}">
                    <div class="row g-2">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                                <input name="q" value="{{ $q }}" class="form-control" placeholder="Search by name, owner, phone...">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <select class="form-select" name="category_id">
                                <option value="">All Categories</option>
                                @foreach($categories ?? [] as $c)
                                    <option value="{{ $c->id }}" {{ (string)$categoryId === (string)$c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <select class="form-select" name="status">
                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Status: All</option>
                                <option value="published" {{ $status === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <select class="form-select" name="city_id">
                                <option value="">City: All</option>
                                @foreach($cities ?? [] as $ct)
                                    <option value="{{ $ct->id }}" {{ (string)$cityId === (string)$ct->id ? 'selected' : '' }}>
                                        {{ $ct->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 d-grid">
                            <button class="btn btn-outline-primary" type="submit">Apply Filters</button>
                        </div>

                        {{-- Clear --}}
                        <div class="col-12">
                            <a class="small text-muted" href="{{ route('admin.listing') }}">Clear filters</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Listing</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Owner</th>
                                <th>Updated</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($listings as $listing)
                                @php
                                    [$badgeText, $badgeClass] = $statusBadge($listing->status);

                                    $categoryName = $listing->category?->name ?? '—';
                                    $cityName     = $listing->city?->name ?? '';
                                    $location     = trim(($listing->meta['area'] ?? '') . ($cityName ? (', ' . $cityName) : ''));
                                    if ($location === '') $location = $cityName ?: '—';

                                    $owner =
                                        $listing->user?->name
                                        ?? ($listing->meta['owner_name'] ?? null)
                                        ?? $listing->meta['company_name'] ?? '—';
                                @endphp

                                <tr>
                                    <td class="fw-semibold">
                                        <div class="d-flex flex-column">
                                            <span>{{ $listing->name }}</span>
                                            <span class="text-muted small">
                                                {{ $listing->tracking_id ? 'ID: '.$listing->tracking_id : 'Slug: '.$listing->slug }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{ $categoryName }}</td>
                                    <td>{{ $location }}</td>
                                    <td>
                                        <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                                    </td>
                                    <td>{{ $owner }}</td>
                                    <td class="text-muted">
                                        {{ $listing->updated_at?->diffForHumans() ?? '—' }}
                                    </td>
                                    <td class="text-end">
                                        @if ($listing->status === 'active')
                                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('listings.show', $listing->id) }}">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-sm btn-outline-secondary disabled" href="#">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @endif

                                        <a class="btn btn-sm btn-outline-primary"
                                           href="#">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="#"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this listing?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        No listings found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        @if(method_exists($listings, 'firstItem') && $listings->total() > 0)
                            Showing {{ $listings->firstItem() }}–{{ $listings->lastItem() }} of {{ $listings->total() }}
                        @else
                            Showing 0 of 0
                        @endif
                    </small>

                    <div>
                        {{ $listings->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="app-footer text-center">&copy; <span id="yearSpan"></span> Directory Admin</div>
    </div>
</main>
@endsection
