@extends('backend.layout')
@section('admin')
    <main class="main-content">
        <div class="container-fluid py-2">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h4 class="mb-1">Review Listing</h4>
                    <p class="mb-0 text-muted small">Check details and verification documents before approval.</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('listings.pending') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>

                    <form method="POST" action="{{ route('listings.approve', $listing->id) }}"
                        onsubmit="return confirm('Approve and publish this listing?');">
                        @csrf
                        <button class="btn btn-success" type="submit">
                            <i class="bi bi-check2"></i> Approve
                        </button>
                    </form>

                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal"
                        data-action="{{ route('listings.reject', $listing->id) }}" data-name="{{ $listing->name }}">
                        <i class="bi bi-x"></i> Reject
                    </button>
                </div>
            </div>

            <div class="row g-3">
                <!-- Left: Main Info -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3 mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between gap-3">
                                <div>
                                    <h5 class="mb-1">{{ $listing->name }}</h5>
                                    <div class="text-muted small">
                                        Tracking: <span class="fw-semibold">{{ $listing->tracking_id ?? '—' }}</span>
                                        <span class="mx-2">•</span>
                                        Status: <span class="badge text-bg-warning">Pending</span>
                                    </div>
                                    <div class="mt-2 small">
                                        <span class="badge text-bg-light">{{ $listing->category?->name ?? '—' }}</span>
                                        <span class="badge text-bg-light">{{ $listing->city?->name ?? '—' }}</span>
                                        @if ($listing->type)
                                            <span class="badge text-bg-light">{{ $listing->type }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-end small text-muted">
                                    Submitted: <div class="fw-semibold">{{ $listing->created_at?->format('d M Y, h:i A') }}
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="small text-muted">Tagline</div>
                                    <div class="fw-semibold">{{ $listing->tagline ?? '—' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <div class="small text-muted">Price Level</div>
                                    <div class="fw-semibold">{{ $listing->price_level ?? '—' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <div class="small text-muted">Email</div>
                                    <div class="fw-semibold">{{ $listing->email ?? '—' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <div class="small text-muted">Phone</div>
                                    <div class="fw-semibold">{{ $listing->phone ?? '—' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <div class="small text-muted">Website</div>
                                    <div class="fw-semibold">
                                        @if ($listing->website)
                                            <a href="{{ \Illuminate\Support\Str::startsWith($listing->website, ['http://', 'https://']) ? $listing->website : 'https://' . $listing->website }}"
                                                target="_blank">{{ $listing->website }}</a>
                                        @else
                                            —
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="small text-muted">Coordinates</div>
                                    <div class="fw-semibold">
                                        {{ $listing->lat ?? '—' }}, {{ $listing->lng ?? '—' }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="small text-muted mb-1">Description</div>
                                <div style="white-space: pre-line;">{{ $listing->description ?? '—' }}</div>
                            </div>

                            @if (!empty($listing->highlights))
                                <div class="mt-3">
                                    <div class="small text-muted mb-1">Highlights</div>
                                    <div style="white-space: pre-line;">{{ $listing->highlights }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Photos -->
                    <div class="card border-0 shadow-sm rounded-3 mb-3">
                        <div class="card-body">
                            <h6 class="mb-2">Submitted Photos</h6>

                            @if ($listing->photos->count())
                                <div class="row g-2">
                                    @foreach ($listing->photos as $photo)
                                        @php
                                            $src = $photo->path ? asset('storage/' . $photo->path) : null;
                                        @endphp
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <div class="border rounded-3 overflow-hidden bg-light"
                                                style="aspect-ratio: 4/3;">
                                                @if ($src)
                                                    <img src="{{ $src }}" alt="photo"
                                                        style="width:100%;height:100%;object-fit:cover;">
                                                @else
                                                    <div
                                                        class="h-100 d-flex align-items-center justify-content-center text-muted">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($photo->is_primary)
                                                <div class="small mt-1"><span class="badge text-bg-primary">Primary</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-muted small">No photos submitted.</div>
                            @endif
                        </div>
                    </div>

                    <!-- Address + Hours -->
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <h6 class="mb-2">Address & Hours</h6>

                            @php $addr = $listing->address; @endphp
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="small text-muted">Address</div>
                                    <div class="fw-semibold">
                                        {{ $addr?->address_line ?? '—' }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $addr?->area ?? '' }}
                                        @if ($listing->city)
                                            {{ $addr?->area ? ',' : '' }} {{ $listing->city->name }}
                                        @endif
                                    </div>
                                    @if ($addr?->postcode)
                                        <div class="text-muted small">Postcode: {{ $addr->postcode }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <div class="small text-muted">Opening Hours</div>

                                    @if ($listing->hours->count())
                                        <div class="table-responsive">
                                            <table class="table table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Day</th>
                                                        <th>Open</th>
                                                        <th>Close</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($listing->hours as $h)
                                                        <tr>
                                                            <td class="fw-semibold">{{ $h->day_name ?? ($h->day ?? '—') }}
                                                            </td>
                                                            <td>{{ $h->open_time ?? '—' }}</td>
                                                            <td>{{ $h->close_time ?? '—' }}</td>
                                                            <td>
                                                                @if (isset($h->is_closed) && $h->is_closed)
                                                                    <span class="badge text-bg-secondary">Closed</span>
                                                                @else
                                                                    <span class="badge text-bg-success">Open</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-muted small">No hours submitted.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Owner + Verification Docs -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3 mb-3">
                        <div class="card-body">
                            <h6 class="mb-2">Owner</h6>
                            <div class="fw-semibold">{{ $listing->owner?->name ?? '—' }}</div>
                            <div class="text-muted small">{{ $listing->owner?->email ?? '' }}</div>
                            <div class="mt-2 small">
                                <div><span class="text-muted">Claimed:</span> <span
                                        class="fw-semibold">{{ $listing->is_claimed ? 'Yes' : 'No' }}</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <h6 class="mb-2">Verification Documents</h6>

                            @php
                                $v = $listing->ownerVerification;
                                // These field names might differ in your ListingOwnerVerification table.
                                // If your columns are different, tell me your migration and I’ll map it perfectly.
                                $nidFront = $v->nid_front_path ?? null;
                                $nidBack = $v->nid_back_path ?? null;
                                $trade = $v->trade_license_path ?? null;
                                $other = $v->other_doc_path ?? null;
                            @endphp

                            @if (!$v)
                                <div class="text-muted small">No verification record submitted.</div>
                            @else
                                <div class="small text-muted mb-2">
                                    Submitted at: <span
                                        class="fw-semibold">{{ $v->created_at?->format('d M Y, h:i A') ?? '—' }}</span>
                                </div>

                                <div class="d-grid gap-2">
                                    <div class="p-2 border rounded-3">
                                        <div class="fw-semibold mb-1">NID Front</div>
                                        @if ($nidFront)
                                            <a class="btn btn-sm btn-outline-primary w-100" target="_blank"
                                                rel="noopener" href="{{ asset('storage/' . $nidFront) }}">
                                                View Document
                                            </a>
                                        @else
                                            <div class="text-muted small">Not provided</div>
                                        @endif
                                    </div>

                                    <div class="p-2 border rounded-3">
                                        <div class="fw-semibold mb-1">NID Back</div>
                                        @if ($nidBack)
                                            <a class="btn btn-sm btn-outline-primary w-100" target="_blank"
                                                rel="noopener" href="{{ asset('storage/' . $nidBack) }}">
                                                View Document
                                            </a>
                                        @else
                                            <div class="text-muted small">Not provided</div>
                                        @endif
                                    </div>

                                    <div class="p-2 border rounded-3">
                                        <div class="fw-semibold mb-1">Trade License</div>
                                        @if ($trade)
                                            <a class="btn btn-sm btn-outline-primary w-100" target="_blank"
                                                rel="noopener" href="{{ asset('storage/' . $trade) }}">
                                                View Document
                                            </a>
                                        @else
                                            <div class="text-muted small">Not provided</div>
                                        @endif
                                    </div>

                                    <div class="p-2 border rounded-3">
                                        <div class="fw-semibold mb-1">Other Document</div>
                                        @if ($other)
                                            <a class="btn btn-sm btn-outline-primary w-100" target="_blank"
                                                rel="noopener" href="{{ asset('storage/' . $other) }}">
                                                View Document
                                            </a>
                                        @else
                                            <div class="text-muted small">Not provided</div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Optional: show raw meta if you stored docs there instead --}}
                                @if (!empty($listing->meta))
                                    <div class="mt-3">
                                        <div class="small text-muted mb-1">Submission Meta</div>
                                        <pre class="small bg-light p-2 rounded-3 mb-0" style="white-space: pre-wrap;">{{ json_encode($listing->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-footer text-center mt-3">&copy; <span id="yearSpan"></span> Directory Admin</div>
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
        (function() {
            const modal = document.getElementById('rejectModal');
            if (!modal) return;

            const form = document.getElementById('rejectForm');
            const nameEl = document.getElementById('rejectListingName');

            modal.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;
                form.action = btn.getAttribute('data-action');
                nameEl.textContent = btn.getAttribute('data-name') || '—';
                form.querySelector('textarea[name="reason"]').value = '';
            });
        })();
    </script>
@endsection
