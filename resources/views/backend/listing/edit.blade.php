@extends('backend.layout')
@section('admin')
    <main class="main-content">
        <div class="container-fluid py-2">

            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h4 class="mb-1">Edit Listing</h4>
                    <p class="mb-0 text-muted small">Update listing info, address, hours, and photos.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <a href="{{ route('listings.pending') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-list"></i> Pending
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <div class="fw-semibold mb-1">Please fix the errors below:</div>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('listings.update', $listing->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- LEFT -->
                    <div class="col-lg-8">

                        <!-- MAIN INFO -->
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between gap-3">
                                    <div>
                                        <h5 class="mb-1">{{ $listing->name }}</h5>
                                        <div class="text-muted small">
                                            Tracking: <span class="fw-semibold">{{ $listing->tracking_id ?? '—' }}</span>
                                            <span class="mx-2">•</span>
                                            Current Status:
                                            <span
                                                class="badge text-bg-{{ $listing->status === 'active' ? 'success' : ($listing->status === 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($listing->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-end small text-muted">
                                        Created: <div class="fw-semibold">
                                            {{ $listing->created_at?->format('d M Y, h:i A') }}</div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Category</label>
                                        <select name="category_id" class="form-select" required>
                                            @foreach ($categories as $c)
                                                <option value="{{ $c->id }}" @selected(old('category_id', $listing->category_id) == $c->id)>
                                                    {{ $c->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">City</label>
                                        <select name="city_id" class="form-select" required>
                                            @foreach ($cities as $c)
                                                <option value="{{ $c->id }}" @selected(old('city_id', $listing->city_id) == $c->id)>
                                                    {{ $c->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name</label>
                                        <input name="name" class="form-control"
                                            value="{{ old('name', $listing->name) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Slug (optional)</label>
                                        <input name="slug" class="form-control"
                                            value="{{ old('slug', $listing->slug) }}">
                                        <div class="form-text">If you change slug, it will auto-fix uniqueness.</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Type</label>
                                        <input name="type" class="form-control"
                                            value="{{ old('type', $listing->type) }}" placeholder="e.g. business, service">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Price Level (0-5)</label>
                                        <input type="number" min="0" max="5" name="price_level"
                                            class="form-control" value="{{ old('price_level', $listing->price_level) }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            @foreach (['pending', 'active', 'inactive', 'rejected'] as $s)
                                                <option value="{{ $s }}" @selected(old('status', $listing->status) === $s)>
                                                    {{ ucfirst($s) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Tagline</label>
                                        <input name="tagline" class="form-control"
                                            value="{{ old('tagline', $listing->tagline) }}">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" rows="5">{{ old('description', $listing->description) }}</textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Highlights</label>
                                        <textarea name="highlights" class="form-control" rows="3" placeholder="One per line">{{ old('highlights', $listing->highlights) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CONTACT + MAP -->
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-body">
                                <h6 class="mb-2">Contact & Location</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input name="email" class="form-control"
                                            value="{{ old('email', $listing->email) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input name="phone" class="form-control"
                                            value="{{ old('phone', $listing->phone) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Website</label>
                                        <input name="website" class="form-control"
                                            value="{{ old('website', $listing->website) }}" placeholder="https://">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Latitude</label>
                                        <input name="lat" class="form-control" value="{{ $listing->lat }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Longitude</label>
                                        <input name="lng" class="form-control" value="{{ $listing->lng }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ADDRESS -->
                        @php $addr = $listing->address; @endphp
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-body">
                                <h6 class="mb-2">Address</h6>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Address Line</label>
                                        <input name="address_line" class="form-control"
                                            value="{{ old('address_line', $addr?->line1) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Area</label>
                                        <input name="area" class="form-control"
                                            value="{{ old('area', $addr?->area) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Postcode</label>
                                        <input name="postcode" class="form-control"
                                            value="{{ old('postcode', $addr?->postal_code) }}">
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- SUBMIT -->
                        <div class="d-flex gap-2 mb-4">
                            <button class="btn btn-primary">
                                <i class="bi bi-save"></i> Save Changes
                            </button>
                            <a class="btn btn-outline-secondary" href="{{ route('listings.pending') }}">
                                Cancel
                            </a>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div class="col-lg-4">

                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-body">
                                <h6 class="mb-2">Owner</h6>
                                <div class="fw-semibold">{{ $listing->owner?->name ?? '—' }}</div>
                                <div class="text-muted small">{{ $listing->owner?->email ?? '' }}</div>

                                <hr>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_claimed" value="1"
                                        @checked(old('is_claimed', $listing->is_claimed))>
                                    <label class="form-check-label">Claimed</label>
                                </div>
                            </div>
                        </div>

                        <!-- PHOTOS -->
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body">
                                <h6 class="mb-2">Photos</h6>

                                @if ($listing->photos->count())
                                    <div class="row g-2">
                                        @foreach ($listing->photos as $p)
                                            @php $src = $p->path ? asset('storage/'.$p->path) : null; @endphp
                                            <div class="col-6">
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

                                                <div class="mt-1 d-flex flex-column gap-1">
                                                    <label class="small">
                                                        <input type="radio" name="primary_photo"
                                                            value="{{ $p->id }}" @checked(old('primary_photo', $listing->photos->firstWhere('is_primary', 1)?->id) == $p->id)>
                                                        Primary
                                                    </label>

                                                    <label class="small text-danger">
                                                        <input type="checkbox" name="delete_photos[]"
                                                            value="{{ $p->id }}">
                                                        Delete
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-text mt-2">Mark photos to delete, and choose one Primary.</div>
                                @else
                                    <div class="text-muted small">No photos uploaded yet.</div>
                                @endif

                                <hr>

                                <label class="form-label">Upload New Photos</label>
                                <input type="file" name="new_photos[]" class="form-control" multiple
                                    accept="image/*">
                                <div class="form-text">jpg/png/webp up to 4MB each.</div>

                            </div>
                        </div>

                    </div>
                </div>
            </form>

            <div class="app-footer text-center mt-3">&copy; <span id="yearSpan"></span> Directory Admin</div>
        </div>
    </main>
@endsection
