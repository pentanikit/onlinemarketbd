@extends('backend.layout')

@section('admin')
<main class="main-content">
  <div class="container-fluid py-2">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
      <div>
        <h4 class="mb-1">Site Content</h4>
        <p class="mb-0 text-muted small">Update homepage sections (About, Manage Listing, Mission, Vision).</p>
      </div>
      <div class="mt-2 mt-md-0 d-flex gap-2">
        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-box-arrow-up-right me-1"></i>Preview Website
        </a>
        <button form="homeContentForm" type="submit" class="btn btn-primary btn-sm">
          <i class="bi bi-check2-circle me-1"></i>Save Changes
        </button>
      </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
      <div class="alert alert-success d-flex align-items-start gap-2">
        <i class="bi bi-check-circle-fill mt-1"></i>
        <div>
          <div class="fw-semibold">Saved</div>
          <div class="small">{{ session('success') }}</div>
        </div>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i>Please fix the errors below:</div>
        <ul class="mb-0 small">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form id="homeContentForm" action="{{ route('home_content.update') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row g-3">

        {{-- Left: Form Sections --}}
        <div class="col-lg-8">

          {{-- ABOUT --}}
          <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="mb-0">About Section</h6>
                <span class="badge bg-light text-dark border small">Homepage</span>
              </div>

              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label small">Title</label>
                  <input type="text"
                         class="form-control @error('about_title') is-invalid @enderror"
                         name="about_title"
                         value="{{ old('about_title', $content->about_title) }}"
                         placeholder="e.g. About Us">
                  @error('about_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                  <label class="form-label small">Description</label>
                  <textarea class="form-control @error('about_body') is-invalid @enderror"
                            name="about_body" rows="5"
                            placeholder="Write about your platform...">{{ old('about_body', $content->about_body) }}</textarea>
                  @error('about_body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  <div class="form-text">Tip: Keep it short and readable (2–4 lines per paragraph).</div>
                </div>
              </div>
            </div>
          </div>

          {{-- MANAGE LISTING --}}
          <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="mb-0">Manage Listing Section</h6>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle small">
                  Image + CTA
                </span>
              </div>

              <div class="row g-3">
                <div class="col-md-8">
                  <label class="form-label small">Title</label>
                  <input type="text"
                         class="form-control @error('manage_title') is-invalid @enderror"
                         name="manage_title"
                         value="{{ old('manage_title', $content->manage_title) }}"
                         placeholder="e.g. Manage your free listing.">
                  @error('manage_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                  <label class="form-label small">Phone (optional)</label>
                  <input type="text"
                         class="form-control @error('manage_phone') is-invalid @enderror"
                         name="manage_phone"
                         value="{{ old('manage_phone', $content->manage_phone) }}"
                         placeholder="e.g. +8801XXXXXXXXX">
                  @error('manage_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                  <label class="form-label small">Description</label>
                  <textarea class="form-control @error('manage_body') is-invalid @enderror"
                            name="manage_body" rows="4"
                            placeholder="Explain the value...">{{ old('manage_body', $content->manage_body) }}</textarea>
                  @error('manage_body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label small">CTA Button Text</label>
                  <input type="text"
                         class="form-control @error('manage_cta_text') is-invalid @enderror"
                         name="manage_cta_text"
                         value="{{ old('manage_cta_text', $content->manage_cta_text) }}"
                         placeholder="e.g. Claim Your Listing">
                  @error('manage_cta_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label small">CTA URL</label>
                  <input type="text"
                         class="form-control @error('manage_cta_url') is-invalid @enderror"
                         name="manage_cta_url"
                         value="{{ old('manage_cta_url', $content->manage_cta_url) }}"
                         placeholder="e.g. /claim or https://example.com">
                  @error('manage_cta_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                  <label class="form-label small">Image</label>
                  <input type="file"
                         class="form-control @error('manage_image') is-invalid @enderror"
                         name="manage_image"
                         accept="image/png,image/jpeg,image/webp"
                         data-preview="#previewManage">
                  @error('manage_image') <div class="invalid-feedback">{{ $message }}</div> @enderror

                  <div class="mt-2 d-flex align-items-center gap-3">
                    <div class="rounded-3 border bg-light overflow-hidden" style="width: 180px; height: 92px;">
                      <img id="previewManage"
                           src="{{ $content->manage_image_url ?: 'https://via.placeholder.com/600x300?text=Manage+Image' }}"
                           alt="Manage Image Preview"
                           style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div class="small text-muted">
                      Recommended: <span class="fw-semibold">1200×600</span> (or similar wide ratio). <br>
                      Allowed: JPG, PNG, WEBP (max 4MB).
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- MISSION --}}
          <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="mb-0">Mission Section</h6>
                <span class="badge bg-light text-dark border small">Image</span>
              </div>

              <div class="row g-3">
                <div class="col-md-8">
                  <label class="form-label small">Title</label>
                  <input type="text"
                         class="form-control @error('mission_title') is-invalid @enderror"
                         name="mission_title"
                         value="{{ old('mission_title', $content->mission_title) }}"
                         placeholder="e.g. Our Mission">
                  @error('mission_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                  <label class="form-label small">Image</label>
                  <input type="file"
                         class="form-control @error('mission_image') is-invalid @enderror"
                         name="mission_image"
                         accept="image/png,image/jpeg,image/webp"
                         data-preview="#previewMission">
                  @error('mission_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                  <label class="form-label small">Description</label>
                  <textarea class="form-control @error('mission_body') is-invalid @enderror"
                            name="mission_body" rows="4"
                            placeholder="Write mission...">{{ old('mission_body', $content->mission_body) }}</textarea>
                  @error('mission_body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                  <div class="rounded-3 border bg-light overflow-hidden" style="max-width: 420px;">
                    <img id="previewMission"
                         src="{{ $content->mission_image_url ?: 'https://via.placeholder.com/900x900?text=Mission+Image' }}"
                         alt="Mission Image Preview"
                         style="width:100%;height:auto;display:block;">
                  </div>
                  <div class="form-text">Recommended: square (e.g. 900×900) for circle frame designs.</div>
                </div>
              </div>
            </div>
          </div>

          {{-- VISION --}}
          <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="mb-0">Vision Section</h6>
                <span class="badge bg-light text-dark border small">Image</span>
              </div>

              <div class="row g-3">
                <div class="col-md-8">
                  <label class="form-label small">Title</label>
                  <input type="text"
                         class="form-control @error('vision_title') is-invalid @enderror"
                         name="vision_title"
                         value="{{ old('vision_title', $content->vision_title) }}"
                         placeholder="e.g. Our Vision">
                  @error('vision_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                  <label class="form-label small">Image</label>
                  <input type="file"
                         class="form-control @error('vision_image') is-invalid @enderror"
                         name="vision_image"
                         accept="image/png,image/jpeg,image/webp"
                         data-preview="#previewVision">
                  @error('vision_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                  <label class="form-label small">Description</label>
                  <textarea class="form-control @error('vision_body') is-invalid @enderror"
                            name="vision_body" rows="4"
                            placeholder="Write vision...">{{ old('vision_body', $content->vision_body) }}</textarea>
                  @error('vision_body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                  <div class="rounded-3 border bg-light overflow-hidden" style="max-width: 420px;">
                    <img id="previewVision"
                         src="{{ $content->vision_image_url ?: 'https://via.placeholder.com/900x900?text=Vision+Image' }}"
                         alt="Vision Image Preview"
                         style="width:100%;height:auto;display:block;">
                  </div>
                  <div class="form-text">Recommended: square (e.g. 900×900). Keep the subject centered.</div>
                </div>
              </div>
            </div>
          </div>

        </div>

        {{-- Right: Tips / Status --}}
        <div class="col-lg-4">
          <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Publishing Tips</h6>
                <span class="badge bg-light text-dark border small">Guidelines</span>
              </div>

              <div class="small text-muted">
                <div class="mb-2 d-flex gap-2">
                  <span class="text-primary"><i class="bi bi-lightning-charge"></i></span>
                  <div><span class="fw-semibold text-dark">Keep it short:</span> users scan quickly.</div>
                </div>
                <div class="mb-2 d-flex gap-2">
                  <span class="text-primary"><i class="bi bi-image"></i></span>
                  <div><span class="fw-semibold text-dark">Use WEBP:</span> smaller + faster loading.</div>
                </div>
                <div class="mb-2 d-flex gap-2">
                  <span class="text-primary"><i class="bi bi-link-45deg"></i></span>
                  <div><span class="fw-semibold text-dark">CTA URL:</span> use a route like <code>/claim</code> or full URL.</div>
                </div>
                <div class="mb-2 d-flex gap-2">
                  <span class="text-primary"><i class="bi bi-check2-square"></i></span>
                  <div><span class="fw-semibold text-dark">Preview after save</span> to confirm spacing & cropping.</div>
                </div>
              </div>

              <hr>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save2 me-1"></i>Save Changes
                </button>
                <a href="{{ route('home_content.edit') }}" class="btn btn-outline-secondary">
                  <i class="bi bi-arrow-clockwise me-1"></i>Reload Page
                </a>
              </div>
            </div>
          </div>

          <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body">
              <h6 class="mb-2">Current Status</h6>
              <div class="small text-muted">
                <div class="d-flex justify-content-between mb-1">
                  <span>Record Key</span>
                  <span class="fw-semibold text-dark">{{ $content->key }}</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                  <span>Last Updated</span>
                  <span class="fw-semibold text-dark">
                    {{ optional($content->updated_at)->format('d M Y, h:i A') }}
                  </span>
                </div>
                <div class="d-flex justify-content-between">
                  <span>Images</span>
                  <span class="fw-semibold text-dark">
                    {{ $content->manage_image ? '✔' : '—' }} /
                    {{ $content->mission_image ? '✔' : '—' }} /
                    {{ $content->vision_image ? '✔' : '—' }}
                  </span>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </form>

    <div class="app-footer text-center">
      &copy; {{ date('Y') }} Directory Admin • Bootstrap 5
    </div>

  </div>
</main>

{{-- Image live preview (tiny JS) --}}
<script>
  document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
    input.addEventListener('change', (e) => {
      const file = e.target.files && e.target.files[0];
      if (!file) return;

      const target = document.querySelector(e.target.getAttribute('data-preview'));
      if (!target) return;

      const url = URL.createObjectURL(file);
      target.src = url;

      // cleanup
      target.onload = () => URL.revokeObjectURL(url);
    });
  });
</script>
@endsection
