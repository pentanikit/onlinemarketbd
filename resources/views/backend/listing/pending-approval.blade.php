@extends('backend.layout')
@section('admin')
<main class="main-content">
  <div class="container-fluid py-2">
    <div class="mb-3 d-flex align-items-center justify-content-between">
      <div>
        <h4 class="mb-1">Pending Approval</h4>
        <p class="mb-0 text-muted small">Review new submissions before publishing.</p>
      </div>
      <div class="small text-muted">
        Total Pending: <span class="fw-semibold">{{ $listings->total() }}</span>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 mb-3">
      <div class="card-body">
        <form method="GET" action="{{ route('listings.pending') }}">
          <div class="row g-2 align-items-end">
            <div class="col-lg-4">
              <label class="form-label small">Search</label>
              <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Listing name / owner / phone / tracking">
            </div>

            <div class="col-lg-3">
              <label class="form-label small">Category</label>
              <select name="category_id" class="form-select">
                <option value="">All</option>
                @foreach($categories as $c)
                  <option value="{{ $c->id }}" {{ (string)request('category_id') === (string)$c->id ? 'selected' : '' }}>
                    {{ $c->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-lg-3">
              <label class="form-label small">City</label>
              <select name="city_id" class="form-select">
                <option value="">All</option>
                @foreach($cities as $city)
                  <option value="{{ $city->id }}" {{ (string)request('city_id') === (string)$city->id ? 'selected' : '' }}>
                    {{ $city->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-lg-2 d-grid gap-2">
              <button class="btn btn-outline-primary" type="submit">
                <i class="bi bi-funnel me-1"></i> Filter
              </button>

              {{-- Reset: shows all pending listings by clearing query string --}}
              @if(request()->filled('q') || request()->filled('category_id') || request()->filled('city_id'))
                <a class="btn btn-outline-secondary" href="{{ route('listings.pending') }}">
                  <i class="bi bi-x-circle me-1"></i> Reset
                </a>
              @endif
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th style="width:60px;">#</th>
                <th>Listing</th>
                <th>Category</th>
                <th>Location</th>
                <th>Owner</th>
                <th>Submitted</th>
                <th class="text-end">Action</th>
              </tr>
            </thead>

            <tbody>
              @forelse($listings as $i => $listing)
                @php
                  $addr = $listing->address;
                  $locationText = trim(($addr->area ?? '') . ((($addr?->area ?? '') && $listing->city?->name) ? ', ' : '') . ($listing->city?->name ?? ''));
                  $locationText = $locationText ?: ($listing->city?->name ?? '—');

                  $thumb = $listing->primaryPhoto?->path ? asset('storage/'.$listing->primaryPhoto->path) : null;
                @endphp

                <tr>
                  <td class="text-muted">{{ $listings->firstItem() + $i }}</td>

                  <td class="fw-semibold">
                    <div class="d-flex align-items-center gap-2">
                      <div class="rounded-2 border bg-light d-flex align-items-center justify-content-center"
                           style="width:40px;height:40px;overflow:hidden;">
                        @if($thumb)
                          <img src="{{ $thumb }}" alt="{{ $listing->name }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                          <i class="bi bi-image text-muted"></i>
                        @endif
                      </div>

                      <div>
                        <div class="mb-0">{{ $listing->name }}</div>
                        <div class="small text-muted">Tracking: {{ $listing->tracking_id ?? '—' }}</div>
                      </div>
                    </div>
                  </td>

                  <td>{{ $listing->category?->name ?? '—' }}</td>
                  <td>{{ $locationText }}</td>

                  <td>
                    <div class="fw-semibold">{{ $listing->owner?->name ?? '—' }}</div>
                    <div class="small text-muted">{{ $listing->owner?->email ?? '' }}</div>
                  </td>

                  <td class="text-muted">{{ $listing->created_at?->diffForHumans() ?? '—' }}</td>

                  <td class="text-end">
                    <a href="{{ route('listings.show', $listing->id) }}" class="btn btn-sm btn-outline-secondary">
                      <i class="bi bi-eye"></i>
                    </a>

                    <form method="POST" action="{{ route('listings.approve', $listing->id) }}" class="d-inline"
                          onsubmit="return confirm('Approve and publish this listing?');">
                      @csrf
                      <button class="btn btn-sm btn-success" type="submit" title="Approve">
                        <i class="bi bi-check2"></i>
                      </button>
                    </form>

                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal"
                            data-action="{{ route('listings.reject', $listing->id) }}"
                            data-name="{{ $listing->name }}">
                      <i class="bi bi-x"></i>
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center py-4 text-muted">
                    No pending listings found.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
          <small class="text-muted">
            Showing {{ $listings->firstItem() ?? 0 }}–{{ $listings->lastItem() ?? 0 }} of {{ $listings->total() }}
          </small>
          <div>{{ $listings->links() }}</div>
        </div>
      </div>
    </div>

    <div class="app-footer text-center">&copy; <span id="yearSpan"></span> Directory Admin</div>
  </div>
</main>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="rejectForm" method="POST" action="#">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Reject Listing</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-2">
            <div class="small text-muted">Listing</div>
            <div class="fw-semibold" id="rejectListingName">—</div>
          </div>

          <div class="mb-0">
            <label class="form-label small">Reason (optional)</label>
            <textarea name="reason" class="form-control" rows="4" placeholder="Write a short rejection note..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Reject</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  (function(){
    const modal = document.getElementById('rejectModal');
    if(!modal) return;

    const form = document.getElementById('rejectForm');
    const nameEl = document.getElementById('rejectListingName');

    modal.addEventListener('show.bs.modal', function (event) {
      const btn = event.relatedTarget;
      form.action = btn.getAttribute('data-action');
      nameEl.textContent = btn.getAttribute('data-name') || '—';
      form.querySelector('textarea[name="reason"]').value = '';
    });
  })();
</script>
@endsection
